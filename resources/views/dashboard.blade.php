<x-app-layout>
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb Navigation -->
        <div class="flex items-center text-sm text-gray-600 mb-4">
            <a href="{{ route('dashboard') }}" class="hover:text-[#0d2d5e] flex items-center font-medium">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                My Drive
            </a>
            @if(($folderId ?? 'root') !== 'root')
                <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-medium text-[#0d2d5e]">{{ $folderName ?? 'Folder' }}</span>
            @endif
        </div>

        <!-- Storage Summary Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-medium text-[#0d2d5e]">Unified Storage</h3>
                    <p class="mt-1 text-sm text-gray-600">{{ $accounts->count() ?? 0 }} account(s) connected</p>
                </div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <a href="{{ route('auth.google') }}" class="w-full sm:w-auto bg-[#0d2d5e] text-white px-4 py-2 rounded-md hover:bg-[#1a3a6b] text-sm text-center font-medium transition">
                        + Connect Another Account
                    </a>
                    <div class="w-full sm:w-64">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-medium text-gray-700">Storage Used</span>
                            <span class="text-xs text-gray-500">{{ $storage['used_gb'] ?? 0 }} GB / {{ $storage['limit_gb'] ? $storage['limit_gb'] . ' GB' : 'Unlimited' }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-[#1e7a3a] h-2 rounded-full transition-all duration-500" style="width: {{ min($storagePercentage ?? 0, 100) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md border border-green-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md border border-red-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- File Manager Section -->
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
            <!-- Toolbar -->
            <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <form action="{{ route('dashboard') }}" method="GET" class="flex w-full sm:w-auto gap-2">
                    <input type="text" name="search" value="{{ $searchQuery ?? '' }}"
                           placeholder="Search in My Drive..."
                           class="flex-1 sm:w-64 rounded-md border-gray-300 shadow-sm focus:border-[#0d2d5e] focus:ring-[#0d2d5e] text-sm">
                    <button type="submit" class="bg-[#0d2d5e] text-white px-4 py-2 rounded-md hover:bg-[#1a3a6b] text-sm">Search</button>
                    @if($searchQuery)
                        <a href="{{ route('dashboard') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 text-sm">Clear</a>
                    @endif
                </form>

                @if(($isConnected ?? false) && !($searchQuery ?? false))
                    <div class="flex space-x-2 w-full sm:w-auto">
                        <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
                                class="flex-1 sm:flex-none inline-flex justify-center items-center px-4 py-2 bg-[#0d2d5e] text-white rounded-md hover:bg-[#1a3a6b] text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Upload
                        </button>
                        <button onclick="document.getElementById('folderModal').classList.remove('hidden')"
                                class="flex-1 sm:flex-none inline-flex justify-center items-center px-4 py-2 bg-[#1e7a3a] text-white rounded-md hover:bg-[#2d8a4e] text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            New Folder
                        </button>
                    </div>
                @endif
            </div>

            <!-- File List Table -->
            @if($isConnected ?? false)
                @if(isset($allFiles) && count($allFiles) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Account</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Modified</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($allFiles as $file)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($file->mimeType == 'application/vnd.google-apps.folder')
                                                    <!-- CLICKABLE FOLDER -->
                                                    <a href="{{ route('dashboard', ['folder' => $file->id]) }}" class="flex items-center group">
                                                        <svg class="w-8 h-8 text-[#e8a020] mr-3 group-hover:text-[#d4901a]" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path></svg>
                                                        <span class="text-sm font-medium text-[#0d2d5e] group-hover:underline truncate max-w-[200px] sm:max-w-xs">{{ $file->name }}</span>
                                                    </a>
                                                @else
                                                    <div class="flex items-center">
                                                        <svg class="w-8 h-8 text-[#0d2d5e] mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path></svg>
                                                        <span class="text-sm font-medium text-gray-900 truncate max-w-[200px] sm:max-w-xs">{{ $file->name }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $file->source_email ?? 'Unknown' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                            {{ \Carbon\Carbon::parse($file->modifiedTime)->format('M d, Y') }}
                                        </td>
                                       <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            @if($file->mimeType != 'application/vnd.google-apps.folder')
                                                <!-- View Icon -->
                                                <a href="{{ route('files.view', ['fileId' => $file->id, 'fileName' => $file->name, 'mimeType' => $file->mimeType]) }}"
                                                target="_blank"
                                                class="text-[#0d2d5e] hover:text-[#1a3a6b] p-1 rounded hover:bg-blue-50" title="View">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>

                                                <!-- Edit Icon (for Google Docs/Sheets/Slides) -->
                                                @if(str_starts_with($file->mimeType ?? '', 'application/vnd.google-apps'))
                                                    <a href="{{ route('files.edit', ['fileId' => $file->id, 'fileName' => $file->name, 'mimeType' => $file->mimeType]) }}"
                                                    target="_blank"
                                                    class="text-[#e8a020] hover:text-[#d4901a] p-1 rounded hover:bg-yellow-50" title="Edit in Google">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                @endif

                                                <!-- Print Icon -->
                                                <a href="{{ route('files.print', ['fileId' => $file->id, 'fileName' => $file->name, 'mimeType' => $file->mimeType]) }}"
                                                target="_blank"
                                                class="text-[#1e7a3a] hover:text-[#2d8a4e] p-1 rounded hover:bg-green-50" title="Print">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                    </svg>
                                                </a>

                                                <!-- Download Icon -->
                                                <a href="{{ route('files.download', ['fileId' => $file->id, 'fileName' => $file->name, 'mimeType' => $file->mimeType]) }}"
                                                class="text-blue-600 hover:text-blue-800 p-1 rounded hover:bg-blue-50" title="Download">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                    </svg>
                                                </a>
                                            @endif

                                            <!-- Delete Icon -->
                                            <form action="{{ route('files.delete', $file->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50" title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No files found</h3>
                        <p class="mt-1 text-sm text-gray-500">@if($searchQuery ?? false) No files match "{{ $searchQuery }}". @else Get started by uploading a file or creating a new folder. @endif</p>
                    </div>
                @endif
            @else
                <div class="p-12 text-center text-gray-500">
                    <p class="mb-4">Please connect your Google Drive to see your files.</p>
                    <a href="{{ route('auth.google') }}" class="inline-block bg-[#0d2d5e] text-white px-6 py-2 rounded-md hover:bg-[#1a3a6b]">Connect Google Drive</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative w-full max-w-md bg-white rounded-lg shadow-xl">
            <div class="flex justify-between items-center p-5 border-b">
                <h3 class="text-lg font-semibold text-[#0d2d5e]">Upload File</h3>
                <button onclick="document.getElementById('uploadModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="p-5">
                @csrf
                <input type="hidden" name="folder_id" value="{{ $folderId ?? 'root' }}">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select File</label>
                    <input type="file" name="file" class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#0d2d5e] focus:border-[#0d2d5e]" required>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-[#0d2d5e] text-white rounded-md hover:bg-[#1a3a6b]">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <!-- New Folder Modal -->
    <div id="folderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative w-full max-w-md bg-white rounded-lg shadow-xl">
            <div class="flex justify-between items-center p-5 border-b">
                <h3 class="text-lg font-semibold text-[#0d2d5e]">Create New Folder</h3>
                <button onclick="document.getElementById('folderModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('folders.create') }}" method="POST" class="p-5">
                @csrf
                <input type="hidden" name="folder_id" value="{{ $folderId ?? 'root' }}">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Folder Name</label>
                    <input type="text" name="name" placeholder="e.g., My Documents" class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#0d2d5e] focus:border-[#0d2d5e]" required>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('folderModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-[#1e7a3a] text-white rounded-md hover:bg-[#2d8a4e]">Create</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
