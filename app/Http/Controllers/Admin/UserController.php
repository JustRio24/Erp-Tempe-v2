<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = \App\Models\User::orderBy('name')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function edit(\App\Models\User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'whatsapp' => 'nullable|string|max:20',
            'is_admin' => 'required|boolean',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui');
    }

    /**
     * Delete the user from the system.
     */
    public function destroy(\App\Models\User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }
}
