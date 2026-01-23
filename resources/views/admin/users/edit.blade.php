@extends('layouts.admin')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit Admin Account: {{ $user->name }}</h1>

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Name Field --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full
                        Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                        @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Field --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email
                        Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                        @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role Field --}}
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
                    <select id="role" name="role" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                        @error('role') border-red-500 @enderror" required>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>Super
                            Admin</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Subscription Info --}}
                @if($user->subscription_end)
                    <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <p class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-2">Current Subscription:</p>
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            {{ $user->subscription_start->format('M d, Y') }} → {{ $user->subscription_end->format('M d, Y') }}
                        </p>
                        @if($user->isSubscriptionActive())
                            <p class="text-sm text-green-600 dark:text-green-400 font-bold">✓ Active
                                ({{ $user->daysRemainingInSubscription() }} days left)</p>
                        @else
                            <p class="text-sm text-red-600 dark:text-red-400 font-bold">✗ Expired</p>
                        @endif
                    </div>
                @else
                    <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">No subscription assigned</p>
                    </div>
                @endif

                {{-- Account Info --}}
                <div
                    class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4 space-y-2">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <span class="font-bold">Created:</span> {{ $user->created_at->format('M d, Y H:i') }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <span class="font-bold">Last Updated:</span> {{ $user->updated_at->format('M d, Y H:i') }}
                    </p>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-4 pt-4">
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        Update Admin Account
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex-1 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white font-semibold py-2 px-4 rounded-lg transition-colors text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection