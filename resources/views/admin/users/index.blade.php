@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        {{-- Header with Add Button --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Admin Accounts</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage super admin and admin accounts</p>
            </div>
            @if(Auth::check() && Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.users.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                    <i class="fas fa-plus"></i> Add Admin
                </a>
            @endif
        </div>

        {{-- Alerts --}}
        @if($errors->any())
            <div
                class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg">
                <strong>Error:</strong>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div
                class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div
                class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        {{-- Users Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Role</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Subscription
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $user->name }}
                                    @if($user->id === Auth::id())
                                        <span
                                            class="ml-2 text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded">You</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        {{ $user->role === 'super_admin' ? 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200' : 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' }}">
                                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    @if($user->subscription_end)
                                        <div>
                                            @if($user->isSubscriptionActive())
                                                <span class="text-green-600 dark:text-green-400">
                                                    <i class="fas fa-check-circle"></i> Active
                                                </span>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    Expires: {{ $user->subscription_end->format('M d, Y') }}
                                                    ({{ $user->daysRemainingInSubscription() }} days left)
                                                </div>
                                            @else
                                                <span class="text-red-600 dark:text-red-400">
                                                    <i class="fas fa-times-circle"></i> Expired
                                                </span>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    Expired: {{ $user->subscription_end->format('M d, Y') }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">No subscription</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm space-x-2">
                                    @if(Auth::check() && Auth::user()->isSuperAdmin())
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <button onclick="changeRole({{ $user->id }}, '{{ $user->role }}')"
                                            class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-300"
                                            title="Change Role">
                                            <i class="fas fa-user-tag"></i>
                                        </button>

                                        <button onclick="changePassword({{ $user->id }})"
                                            class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300"
                                            title="Change Password">
                                            <i class="fas fa-key"></i>
                                        </button>

                                        <button onclick="extendSubscription({{ $user->id }})"
                                            class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300"
                                            title="Extend Subscription">
                                            <i class="fas fa-calendar-plus"></i>
                                        </button>

                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                                    No admin accounts found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="flex justify-center">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- Modals --}}

    {{-- Change Role Modal --}}
    <div id="changeRoleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-96">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Change Role</h3>
            <form id="changeRoleForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Role:</label>
                    <select name="role"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="admin">Admin</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        Update
                    </button>
                    <button type="button" onclick="closeModal('changeRoleModal')"
                        class="flex-1 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white px-4 py-2 rounded-lg transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Extend Subscription Modal --}}
    <div id="extendSubscriptionModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-96">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Extend Subscription</h3>
            <form id="extendSubscriptionForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Days to Add:</label>
                    <input type="number" name="days" min="1" max="365" value="30"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                        required>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                        Extend
                    </button>
                    <button type="button" onclick="closeModal('extendSubscriptionModal')"
                        class="flex-1 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white px-4 py-2 rounded-lg transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Change Password Modal --}}
    <div id="changePasswordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-96">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Change Password</h3>
            <form id="changePasswordForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password:</label>
                    <input type="password" name="new_password"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Minimum 8 characters" minlength="8" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password:</label>
                    <input type="password" name="new_password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Confirm password" minlength="8" required>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="flex-1 bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition-colors">
                        Change Password
                    </button>
                    <button type="button" onclick="closeModal('changePasswordModal')"
                        class="flex-1 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white px-4 py-2 rounded-lg transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function changeRole(userId, currentRole) {
            const form = document.getElementById('changeRoleForm');
            form.action = `/admin/users/${userId}/change-role`;
            document.querySelector('select[name="role"]').value = currentRole;
            openModal('changeRoleModal');
        }

        function changePassword(userId) {
            const form = document.getElementById('changePasswordForm');
            form.action = `/admin/users/${userId}/change-password`;
            form.reset();
            openModal('changePasswordModal');
        }

        function extendSubscription(userId) {
            const form = document.getElementById('extendSubscriptionForm');
            form.action = `/admin/users/${userId}/extend-subscription`;
            openModal('extendSubscriptionModal');
        }

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // Close modals on background click
        document.querySelectorAll('[id$="Modal"]').forEach(modal => {
            modal.addEventListener('click', function (e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
        });
    </script>
@endsection