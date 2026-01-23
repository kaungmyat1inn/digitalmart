<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of admin users
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new admin
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created admin in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,super_admin',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin account created successfully');
    }

    /**
     * Show the form for editing an admin
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified admin in storage
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,super_admin',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin account updated successfully');
    }

    /**
     * Delete (soft delete) the specified admin
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'Admin account deleted successfully');
    }

    /**
     * Restore a soft-deleted admin
     */
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin account restored successfully');
    }

    /**
     * Change admin role
     */
    public function changeRole(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role');
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,super_admin',
        ]);

        $user->update($validated);
        return back()->with('success', 'Role updated successfully');
    }

    /**
     * Extend subscription period for admin
     */
    public function extendSubscription(Request $request, User $user)
    {
        $validated = $request->validate([
            'days' => 'required|integer|min:1|max:365',
        ]);

        $newEndDate = $user->subscription_end
            ? $user->subscription_end->addDays($validated['days'])
            : now()->addDays($validated['days']);

        $user->update([
            'subscription_start' => $user->subscription_start ?? now(),
            'subscription_end' => $newEndDate,
        ]);

        return back()->with('success', 'Subscription extended by ' . $validated['days'] . ' days');
    }

    /**
     * Change password for admin
     */
    public function changePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return back()->with('success', 'Password updated successfully');
    }
}
