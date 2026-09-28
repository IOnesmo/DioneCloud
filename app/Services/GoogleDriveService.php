<?php

namespace App\Services;

use App\Models\LinkedAccount;
use Google\Client;
use Google\Service\Drive;

class GoogleDriveService
{
    protected $client;
    protected $account;

    public function __construct($linkedAccount)
    {
        $this->account = $linkedAccount;
        if (!$this->account) {
            throw new \Exception('Google Drive account not found.');
        }

        $this->client = new Client();
        $this->client->setClientId(env('GOOGLE_CLIENT_ID'));
        $this->client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));

        $this->client->setAccessToken([
            'access_token' => $this->account->access_token,
            'refresh_token' => $this->account->refresh_token,
            'expires_in' => $this->account->expires_at ? $this->account->expires_at->diffInSeconds(now()) : 0,
        ]);
    }

    public function getClient()
    {
        if (!$this->client) {
            throw new \Exception('Google Drive is not connected.');
        }

        if ($this->client->isAccessTokenExpired()) {
            if ($this->client->getRefreshToken()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                $this->account->update([
                    'access_token' => $this->client->getAccessToken()['access_token'],
                    'expires_at' => now()->addSeconds($this->client->getAccessToken()['expires_in']),
                ]);
            } else {
                throw new \Exception('Refresh token missing. Please reconnect this account.');
            }
        }
        return $this->client;
    }

    public function getStorageQuota()
    {
        try {
            $service = new Drive($this->getClient());
            $about = $service->about->get(['fields' => 'storageQuota']);
            $quota = $about->getStorageQuota();

            return [
                'used' => (int) $quota->getUsage(),
                'limit' => (int) $quota->getLimit(),
            ];
        } catch (\Exception $e) {
            throw new \Exception('Failed to get storage quota: ' . $e->getMessage());
        }
    }

    public function listFilesInFolder($folderId = 'root')
    {
        $service = new Drive($this->getClient());
        $q = "'" . $folderId . "' in parents and trashed = false";

        $response = $service->files->listFiles([
            'pageSize' => 100,
            'fields' => 'nextPageToken, files(id, name, mimeType, modifiedTime, size)',
            'q' => $q,
            'orderBy' => 'folder, modifiedTime desc'
        ]);
        return $response->getFiles();
    }

    public function searchFiles($query)
    {
        $service = new Drive($this->getClient());
        $q = "name contains '" . addslashes($query) . "' and trashed = false";

        $response = $service->files->listFiles([
            'pageSize' => 50,
            'fields' => 'nextPageToken, files(id, name, mimeType, modifiedTime, size)',
            'q' => $q,
            'orderBy' => 'modifiedTime desc'
        ]);
        return $response->getFiles();
    }

    public function getFileInfo($fileId)
    {
        $service = new Drive($this->getClient());
        return $service->files->get($fileId, ['fields' => 'id, name, mimeType']);
    }

    public function getFileWebViewLink($fileId)
    {
        $service = new Drive($this->getClient());
        $file = $service->files->get($fileId, ['fields' => 'webViewLink']);
        return $file->getWebViewLink();
    }

    public function uploadFile($file, $parentId = null)
    {
        $service = new Drive($this->getClient());
        $fileMetadata = new \Google\Service\Drive\DriveFile([
            'name' => $file->getClientOriginalName(),
            'parents' => $parentId ? [$parentId] : ['root']
        ]);
        $content = file_get_contents($file->getRealPath());
        return $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $file->getMimeType(),
            'uploadType' => 'multipart'
        ]);
    }

    public function downloadFile($fileId)
    {
        $service = new Drive($this->getClient());
        $response = $service->files->get($fileId, ['alt' => 'media']);
        return $response->getBody()->getContents();
    }

    public function exportFile($fileId, $mimeType)
    {
        $service = new Drive($this->getClient());
        $response = $service->files->export($fileId, $mimeType);
        return $response->getBody()->getContents();
    }

    public function deleteFile($fileId)
    {
        $service = new Drive($this->getClient());
        $service->files->delete($fileId);
        return true;
    }

    public function createFolder($name, $parentId = null)
    {
        $service = new Drive($this->getClient());
        $fileMetadata = new \Google\Service\Drive\DriveFile([
            'name' => $name,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => $parentId ? [$parentId] : ['root']
        ]);
        return $service->files->create($fileMetadata);
    }
}
