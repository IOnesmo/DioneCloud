<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Connected Accounts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header with Storage Summary -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-white">
                    <h3 class="text-lg font-bold">Your Unified Storage Pool</h3>
                    <div class="mt-4 grid grid-cols-3 gap-4">
                        <div class="bg-white bg-opacity-20 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold">{{ $accounts->count() }}</p>
                            <p class="text-xs opacity-90">Accounts Connected</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold">{{ $accounts->where('is_combined', true)->count() }}</p>
                            <p class="text-xs opacity-90">Accounts Active</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold">{{ $accounts->where('is_combined', true)->count() * 15 }} GB</p>
                            <p class="text-xs opacity-90">Total Storage</p>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Instructions Box -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <svg class="w-6 h-6 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-bold text-yellow-800 mb-2">How to Connect Multiple Gmail Accounts:</h4>
                        <ol class="text-sm text-yellow-700 space-y-1 list-decimal list-inside">
                            <li>Click the green "Connect New Account" button below</li>
                            <li>When Google shows the account picker, select the Gmail account you want to add</li>
                            <li>Click "Allow" to grant permissions</li>
                            <li>Repeat to add more accounts</li>
                            <li>Check the boxes next to accounts you want to combine</li>
                            <li>Click "Save Selection" to update your unified storage</li>
                        </ol>
                        <p class="text-xs text-yellow-600 mt-2">
                            <strong>Tip:</strong> If Google doesn't show the account picker, sign out of all Google accounts first, or use an Incognito window.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Connected Accounts Form -->
            <form action="{{ route('accounts.update') }}" method="POST">
                @csrf

                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">
                            Connected Accounts ({{ $accounts->count() }})
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Check the accounts you want to include in your unified storage
                        </p>
                    </div>

                    <ul class="divide-y divide-gray-200">
                        @forelse($accounts as $account)
                            <li class="p-4 hover:bg-gray-50 transition duration-150 {{ $account->is_combined ? 'bg-blue-50' : '' }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center flex-1">
                                        <!-- Checkbox -->
                                        <input type="checkbox"
                                               name="account_ids[]"
                                               value="{{ $account->id }}"
                                               id="account-{{ $account->id }}"
                                               {{ $account->is_combined ? 'checked' : '' }}
                                               class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 cursor-pointer">

                                        <!-- Account Icon & Info -->
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold mr-3">
                                                    {{ strtoupper(substr($account->email, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <label for="account-{{ $account->id }}" class="cursor-pointer">
                                                        <p class="text-sm font-semibold text-gray-900">{{ $account->email }}</p>
                                                        <p class="text-xs text-gray-500 mt-0.5">
                                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                                            </svg>
                                                            ID: {{ Str::limit($account->provider_id, 20) }}
                                                        </p>
                                                    </label>
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-400 mt-2 ml-14">
                                                Connected: {{ $account->created_at->format('M d, Y \a\t h:i A') }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Storage Badge & Actions -->
                                    <div class="ml-4 flex items-center space-x-4">
                                        <div class="text-right">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                                                15 GB
                                            </span>
                                            @if($account->is_combined)
                                                <p class="text-xs text-green-600 mt-1 font-medium">✓ Active</p>
                                            @else
                                                <p class="text-xs text-gray-400 mt-1">Inactive</p>
                                            @endif
                                        </div>

                                        <!-- Remove Button -->
                                        <form action="{{ route('accounts.remove', $account->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Are you sure you want to remove {{ $account->email }}? This will delete all tokens and files from this account.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 transition" title="Remove Account">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="p-8 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No accounts connected</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by connecting your first Gmail account.</p>
                            </li>
                        @endforelse
                    </ul>

                    @if($accounts->count() > 0)
                        <!-- Action Buttons -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                                <div class="text-sm text-gray-700">
                                    <span class="font-semibold text-blue-600">{{ $accounts->where('is_combined', true)->count() }}</span>
                                    account(s) selected •
                                    Total: <span class="font-bold text-lg text-blue-600">{{ $accounts->where('is_combined', true)->count() * 15 }} GB</span>
                                </div>

                                <div class="flex space-x-3 w-full sm:w-auto">
                                    <a href="{{ route('dashboard') }}" class="flex-1 sm:flex-none px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-center font-medium transition">
                                        Back to Dashboard
                                    </a>
                                    <button type="submit" class="flex-1 sm:flex-none px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-bold shadow-lg transition transform hover:scale-105">
                                        Save Selection
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </form>

            <!-- Connect New Account Section -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 shadow-lg sm:rounded-lg p-6">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-white">
                        <h4 class="text-lg font-bold">Want to add more storage?</h4>
                        <p class="text-sm text-green-100 mt-1">
                            Connect another Gmail account to add 15 GB more to your unified storage.
                        </p>
                        <div class="mt-3 flex items-center text-xs text-green-100">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Each account = 15 GB free storage
                        </div>
                    </div>
                    <a href="{{ route('auth.google') }}" class="w-full sm:w-auto px-6 py-3 bg-white text-green-600 rounded-lg hover:bg-gray-100 font-bold shadow-md transition transform hover:scale-105 inline-flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                        </svg>
                        Connect New Account
                    </a>
                </div>
            </div>

            <!-- Quick Stats -->
            @if($accounts->count() > 0)
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Active Accounts</p>
                                <p class="text-lg font-bold text-gray-900">{{ $accounts->where('is_combined', true)->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Potential Storage</p>
                                <p class="text-lg font-bold text-gray-900">{{ $accounts->count() * 15 }} GB</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Current Storage</p>
                                <p class="text-lg font-bold text-gray-900">{{ $accounts->where('is_combined', true)->count() * 15 }} GB</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
