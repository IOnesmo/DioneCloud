<?php

namespace App\Http\Controllers;

use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    public function index(Request $request)
    {
         // Make sure user is authenticated
    if (!auth()->check()) {
        return redirect()->route('login');
    }
        $searchQuery = $request->input('search');
        $folderId = $request->input('folder', 'root');

        // 1. Get ALL connected Google accounts
       $accounts = \App\Models\LinkedAccount::where('user_id', auth()->id())
    ->where('provider', 'google')
    ->where('is_combined', true)
    ->get();

        $isConnected = $accounts->count() > 0;
        $allFiles = [];

        // 2. Initialize defaults to prevent undefined variable errors
        $storage = ['used_gb' => 0, 'limit_gb' => null];
        $storagePercentage = 0;
        $folderName = 'Unified Drive';

        if ($isConnected) {
            try {
                $totalUsed = 0;
                $totalLimit = 0;

                // 3. Loop through EACH account and aggregate data
                foreach ($accounts as $account) {
                    $service = new GoogleDriveService($account);

                    $quota = $service->getStorageQuota();
                    $totalUsed += $quota['used'];
                    if ($quota['limit']) {
                        $totalLimit += $quota['limit']; // THIS IS HOW 15GB + 15GB = 30GB
                    }

                    $files = $service->listFiles();

                    foreach ($files as $file) {
                        $file->source_email = $account->email ?? $account->provider_id;
                        $allFiles[] = $file;
                    }
                }

                // Sort all combined files by date (newest first)
                usort($allFiles, function($a, $b) {
                    return strtotime($b->modifiedTime) - strtotime($a->modifiedTime);
                });

                // Limit to 30 files for a clean dashboard
                $allFiles = array_slice($allFiles, 0, 30);

                $storagePercentage = ($totalLimit > 0) ? round(($totalUsed / $totalLimit) * 100, 2) : 0;
                $storage = [
                    'used_gb' => round($totalUsed / 1073741824, 2),
                    'limit_gb' => $totalLimit > 0 ? round($totalLimit / 1073741824, 2) : null
                ];

            } catch (\Exception $e) {
                return back()->with('error', 'Failed to aggregate drives: ' . $e->getMessage());
            }
        }

        // 4. All variables are guaranteed to exist
        return view('dashboard', compact(
            'allFiles', 'isConnected', 'storage', 'storagePercentage', 'searchQuery', 'accounts', 'folderId', 'folderName'
        ));
    }

    public function upload(GoogleDriveService $driveService, Request $request)
    {
        $request->validate(['file' => 'required|file|max:10240']);
        try {
            $driveService->uploadFile($request->file('file'), $request->input('folder_id', 'root'));
            return back()->with('success', 'File uploaded successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function download(GoogleDriveService $driveService, $fileId, $fileName, $mimeType = null)
    {
        try {
            if ($mimeType && str_starts_with($mimeType, 'application/vnd.google-apps')) {
                $exportFormat = $this->getExportFormat($mimeType);
                $content = $driveService->exportFile($fileId, $exportFormat);
                $extension = $this->getExtensionFromFormat($exportFormat);
                $downloadName = $fileName . '.' . $extension;
            } else {
                $content = $driveService->downloadFile($fileId);
                $downloadName = $fileName;
            }

            return response($content)
                ->header('Content-Type', 'application/octet-stream')
                ->header('Content-Disposition', 'attachment; filename="' . $downloadName . '"');
        } catch (\Exception $e) {
            return back()->with('error', 'Download failed: ' . $e->getMessage());
        }
    }

    public function delete(GoogleDriveService $driveService, $fileId)
    {
        try {
            $driveService->deleteFile($fileId);
            return back()->with('success', 'File deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    public function createFolder(GoogleDriveService $driveService, Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        try {
            $driveService->createFolder($request->input('name'), $request->input('folder_id', 'root'));
            return back()->with('success', 'Folder created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Folder creation failed: ' . $e->getMessage());
        }
    }

    private function getExportFormat($mimeType)
    {
        $formats = [
            'application/vnd.google-apps.document' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.google-apps.spreadsheet' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.google-apps.presentation' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.google-apps.form' => 'application/zip',
            'application/vnd.google-apps.drawing' => 'image/png',
        ];
        return $formats[$mimeType] ?? 'application/pdf';
    }

    private function getExtensionFromFormat($format)
    {
        $extensions = [
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/zip' => 'zip',
            'image/png' => 'png',
            'application/pdf' => 'pdf',
        ];
        return $extensions[$format] ?? 'pdf';
    }
}
