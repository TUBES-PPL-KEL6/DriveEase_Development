<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'status' => 'required|in:active,disabled',
        ]);
        $user->update($request->only('name', 'email', 'status'));
        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->update(['status' => 'disabled']);
        // Optionally, log this action
        return redirect()->route('admin.users.index')->with('success', 'User disabled.');
    }
} 