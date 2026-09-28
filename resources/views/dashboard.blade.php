<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

           <!-- Cloud Storage Connections -->
<div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
    <!-- Manage Accounts Button -->
    <a href="{{ route('accounts.manage') }}" class="w-full sm:w-auto bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 text-sm text-center font-medium transition duration-150 ease-in-out inline-flex items-center justify-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        Manage Accounts
    </a>

    @if($isConnected)
        <div class="space-y-2 w-full sm:w-auto">
            @foreach($accounts as $acc)
                <div class="flex items-center text-sm text-gray-600 bg-gray-50 px-3 py-1 rounded-md border border-gray-200">
                    <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="truncate max-w-[200px]">{{ $acc->email ?? $acc->provider_id }}</span>
                    <span class="ml-2 text-xs text-gray-400">(15 GB)</span>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Connect Account Modal -->
<div id="connectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-6 border w-11/12 sm:w-[500px] shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Connect Google Account</h3>
            <button onclick="document.getElementById('connectModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="space-y-4">
            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-blue-700 font-medium">How it works:</p>
                        <p class="text-xs text-blue-600 mt-1">
                            When you click "Connect", Google will show you all your signed-in accounts.
                            Select the Gmail account you want to add. Each account adds <strong>15 GB</strong> to your unified storage.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Current Status -->
            <div class="border rounded-lg p-4">
                <p class="text-sm font-medium text-gray-700 mb-2">Currently Connected:</p>
                @if($accounts->count() > 0)
                    <ul class="space-y-1">
                        @foreach($accounts as $acc)
                            <li class="text-sm text-gray-600 flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $acc->email ?? $acc->provider_id }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500">No accounts connected yet.</p>
                @endif
            </div>

            <!-- Storage Preview -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-sm font-medium text-green-700 mb-2">Storage Preview:</p>
                <div class="flex justify-between text-sm">
                    <span class="text-green-600">Current: {{ $accounts->count() }} accounts = {{ $accounts->count() * 15 }} GB</span>
                    <span class="text-green-700 font-bold">After adding: {{ ($accounts->count() + 1) * 15 }} GB</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 pt-4 border-t">
                <button onclick="document.getElementById('connectModal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Cancel
                </button>
                <a href="{{ route('auth.google') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                    </svg>
                    Connect Google Account
                </a>
            </div>
        </div>
    </div>
</div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <!-- File Manager Section -->
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Search Bar -->
                    <div class="md:col-span-2 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                            <input type="text" name="search" value="{{ $searchQuery ?? '' }}"
                                   placeholder="Search your unified files..."
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 w-full">
                            <div class="flex gap-2">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 w-full sm:w-auto">Search</button>
                                @if($searchQuery)
                                    <a href="{{ route('dashboard') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 text-center w-full sm:w-auto">Clear</a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Storage Usage -->
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="text-sm font-medium text-gray-700">Unified Storage</h4>
                            <span class="text-sm text-gray-500 font-semibold">
                                {{ $storage['used_gb'] ?? 0 }} GB / {{ $storage['limit_gb'] ? $storage['limit_gb'] . ' GB' : 'Unlimited' }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ min($storagePercentage, 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $storagePercentage }}% used</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center space-x-2">
                        <h3 class="text-lg font-medium text-gray-900">{{ $folderName }}</h3>
                    </div>

                    @if($isConnected && !$searchQuery)
                        <div class="flex space-x-2 w-full sm:w-auto">
                            <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
                                    class="flex-1 sm:flex-none inline-flex justify-center items-center px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                Upload
                            </button>
                            <button onclick="document.getElementById('folderModal').classList.remove('hidden')"
                                    class="flex-1 sm:flex-none inline-flex justify-center items-center px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                                New Folder
                            </button>
                        </div>
                    @endif
                </div>

                @if($isConnected)
                    @if(isset($allFiles) && count($allFiles) > 0)
                        <div class="bg-white shadow overflow-hidden sm:rounded-md">
                            <ul role="list" class="divide-y divide-gray-200">
                                @foreach($allFiles as $file)
                                    <li class="px-4 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between hover:bg-gray-50 gap-3">
                                        <div class="flex items-center flex-1 min-w-0">
                                            <div class="flex-shrink-0 mr-3">
                                                @if($file->mimeType == 'application/vnd.google-apps.folder')
                                                    <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path></svg>
                                                @else
                                                    <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path></svg>
                                                @endif
                                            </div>

                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-blue-600 truncate">{{ $file->name }}</p>
                                                <div class="flex flex-wrap items-center mt-1 gap-2">
                                                    <span class="text-xs text-gray-500 truncate">{{ $file->mimeType }}</span>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                        {{ $file->source_email ?? 'Unknown' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center space-x-3 pl-11 sm:pl-0">
                                            @if($file->mimeType != 'application/vnd.google-apps.folder')
                                                <a href="{{ route('files.download', ['fileId' => $file->id, 'fileName' => $file->name, 'mimeType' => $file->mimeType]) }}"
                                                   class="text-gray-400 hover:text-blue-600" title="Download">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                    </svg>
                                                </a>
                                            @endif

                                            <form action="{{ route('files.delete', $file->id) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600" title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="bg-white p-8 rounded-md shadow text-center text-gray-500">
                            @if($searchQuery) No files found matching "{{ $searchQuery }}". @else This unified drive is empty. Connect an account or upload files. @endif
                        </div>
                    @endif
                @else
                    <div class="bg-gray-50 p-6 rounded-md text-center text-gray-500">Please connect your Google Drive to see your files.</div>
                @endif
            </div>

        </div>
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 sm:w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-medium mb-4">Upload File</h3>
            <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="folder_id" value="{{ $folderId ?? 'root' }}">
                <div class="mb-4">
                    <input type="file" name="file" class="w-full border rounded-md p-2" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <!-- New Folder Modal -->
    <div id="folderModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 sm:w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-medium mb-4">Create New Folder</h3>
            <form action="{{ route('folders.create') }}" method="POST">
                @csrf
                <input type="hidden" name="folder_id" value="{{ $folderId ?? 'root' }}">
                <div class="mb-4">
                    <input type="text" name="name" placeholder="Folder name" class="w-full border rounded-md p-2" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('folderModal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Create</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
