<?php

namespace App\Http\Controllers;

use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FileManagerController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('search');
        $folderId = $request->input('folder', 'root');

        $accounts = \App\Models\LinkedAccount::where('user_id', auth()->id())
            ->where('provider', 'google')
            ->get();

        $isConnected = $accounts->count() > 0;
        $allFiles = [];
        $totalUsed = 0;
        $totalLimit = 0;
        $folderName = 'My Drive';
        $errors = [];

        if ($isConnected) {
            foreach ($accounts as $account) {
                try {
                    $service = new GoogleDriveService($account);

                    $quota = $service->getStorageQuota();
                    $totalUsed += $quota['used'];
                    if ($quota['limit'] > 0) {
                        $totalLimit += $quota['limit'];
                    }

                    if ($searchQuery) {
                        $files = $service->searchFiles($searchQuery);
                    } else {
                        $files = $service->listFilesInFolder($folderId);

                        if ($folderId !== 'root' && $folderName === 'My Drive') {
                            try {
                                $folderInfo = $service->getFileInfo($folderId);
                                if ($folderInfo) $folderName = $folderInfo->name;
                            } catch (\Exception $e) {
                                // Ignore
                            }
                        }
                    }

                    foreach ($files as $file) {
                        $file->source_email = $account->email ?? $account->provider_id;
                        $allFiles[] = $file;
                    }
                } catch (\Exception $e) {
                    $errors[] = $account->email . ': ' . $e->getMessage();
                }
            }

            usort($allFiles, function($a, $b) {
                $aIsFolder = $a->mimeType == 'application/vnd.google-apps.folder';
                $bIsFolder = $b->mimeType == 'application/vnd.google-apps.folder';

                if ($aIsFolder && !$bIsFolder) return -1;
                if (!$aIsFolder && $bIsFolder) return 1;

                return strtotime($b->modifiedTime) - strtotime($a->modifiedTime);
            });

            $allFiles = array_slice($allFiles, 0, 100);
        }

        $storageUsedGB = round($totalUsed / 1073741824, 2);
        $storageLimitGB = $totalLimit > 0 ? round($totalLimit / 1073741824, 2) : null;
        $storagePercentage = $totalLimit > 0 ? round(($totalUsed / $totalLimit) * 100, 2) : 0;

        $storage = [
            'used_gb' => $storageUsedGB,
            'limit_gb' => $storageLimitGB
        ];

        if (!empty($errors)) {
            session()->flash('error', 'Issues: ' . implode(' | ', $errors));
        }

        return view('dashboard', compact(
            'allFiles', 'isConnected', 'storage', 'storagePercentage',
            'searchQuery', 'accounts', 'folderId', 'folderName'
        ));
    }

    public function upload(Request $request)
    {
        try {
            $request->validate(['file' => 'required|file|max:10240']);
            $account = \App\Models\LinkedAccount::where('user_id', auth()->id())
                ->where('provider', 'google')
                ->first();

            if (!$account) return back()->with('error', 'No Google account connected.');

            $service = new GoogleDriveService($account);
            $service->uploadFile($request->file('file'), $request->input('folder_id', 'root'));
            return back()->with('success', 'File uploaded successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function createFolder(Request $request)
    {
        try {
            $request->validate(['name' => 'required|string|max:255']);
            $account = \App\Models\LinkedAccount::where('user_id', auth()->id())
                ->where('provider', 'google')
                ->first();

            if (!$account) return back()->with('error', 'No Google account connected.');

            $service = new GoogleDriveService($account);
            $service->createFolder($request->input('name'), $request->input('folder_id', 'root'));
            return back()->with('success', 'Folder created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Folder creation failed: ' . $e->getMessage());
        }
    }

    public function view(Request $request, $fileId, $fileName, $mimeType = null)
    {
        try {
            $account = \App\Models\LinkedAccount::where('user_id', auth()->id())
                ->where('provider', 'google')
                ->first();

            if (!$account) return back()->with('error', 'No account connected.');

            $service = new GoogleDriveService($account);

            // For Google Docs/Sheets/Slides, open in browser
            if ($mimeType && str_starts_with($mimeType, 'application/vnd.google-apps')) {
                $webViewLink = $service->getFileWebViewLink($fileId);
                return redirect($webViewLink);
            }

            // For other files, show preview
            $content = $service->downloadFile($fileId);
            $contentType = $this->getContentType($mimeType);

            return response($content)
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
        } catch (\Exception $e) {
            return back()->with('error', 'View failed: ' . $e->getMessage());
        }
    }

    public function edit(Request $request, $fileId, $fileName, $mimeType = null)
    {
        try {
            $account = \App\Models\LinkedAccount::where('user_id', auth()->id())
                ->where('provider', 'google')
                ->first();

            if (!$account) return back()->with('error', 'No account connected.');

            $service = new GoogleDriveService($account);

            // Open in Google editor
            $webViewLink = $service->getFileWebViewLink($fileId);
            // Convert view link to edit link
            $editLink = str_replace('/view', '/edit', $webViewLink);

            return redirect($editLink);
        } catch (\Exception $e) {
            return back()->with('error', 'Edit failed: ' . $e->getMessage());
        }
    }

    public function print(Request $request, $fileId, $fileName, $mimeType = null)
    {
        try {
            $account = \App\Models\LinkedAccount::where('user_id', auth()->id())
                ->where('provider', 'google')
                ->first();

            if (!$account) return back()->with('error', 'No account connected.');

            $service = new GoogleDriveService($account);

            // For Google Docs, export as PDF and open print dialog
            if ($mimeType && str_starts_with($mimeType, 'application/vnd.google-apps')) {
                $content = $service->exportFile($fileId, 'application/pdf');
                return response($content)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'inline; filename="' . $fileName . '.pdf"');
            }

            // For other files, show in browser for printing
            $content = $service->downloadFile($fileId);
            $contentType = $this->getContentType($mimeType);

            return response($content)
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
        } catch (\Exception $e) {
            return back()->with('error', 'Print failed: ' . $e->getMessage());
        }
    }

    public function download(Request $request, $fileId, $fileName, $mimeType = null)
    {
        try {
            $account = \App\Models\LinkedAccount::where('user_id', auth()->id())
                ->where('provider', 'google')
                ->first();

            if (!$account) return back()->with('error', 'No account connected.');

            $service = new GoogleDriveService($account);

            if ($mimeType && str_starts_with($mimeType, 'application/vnd.google-apps')) {
                $content = $service->exportFile($fileId, 'application/pdf');
                $downloadName = $fileName . '.pdf';
            } else {
                $content = $service->downloadFile($fileId);
                $downloadName = $fileName;
            }

            return response($content)
                ->header('Content-Type', 'application/octet-stream')
                ->header('Content-Disposition', 'attachment; filename="' . $downloadName . '"');
        } catch (\Exception $e) {
            return back()->with('error', 'Download failed: ' . $e->getMessage());
        }
    }

    public function delete($fileId)
    {
        try {
            $account = \App\Models\LinkedAccount::where('user_id', auth()->id())
                ->where('provider', 'google')
                ->first();

            if (!$account) return back()->with('error', 'No account connected.');

            $service = new GoogleDriveService($account);
            $service->deleteFile($fileId);
            return back()->with('success', 'File deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    private function getContentType($mimeType)
    {
        $types = [
            'image/jpeg' => 'image/jpeg',
            'image/png' => 'image/png',
            'image/gif' => 'image/gif',
            'application/pdf' => 'application/pdf',
            'text/plain' => 'text/plain',
            'text/html' => 'text/html',
        ];
        return $types[$mimeType] ?? 'application/octet-stream';
    }
}
