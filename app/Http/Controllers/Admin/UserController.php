<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.pages.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|string|min:8|confirmed', // Validasi password
            'role'              => 'required|in:admin,user',
            'photo'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = new User();
        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->role    = $request->role;
        $user->password = bcrypt($request->password); // Enkripsi password

        // Upload foto jika ada
        if ($request->hasFile('photo')) {
            $file     = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/photos/users', $filename);
            $user->photo = $filename;
        } else {
            $user->photo = 'default.jpg'; // default photo
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'role'  => 'required|in:admin,user',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->role  = $request->role;

        // Update photo jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama (jika bukan default)
            if ($user->photo && $user->photo != 'default.png') {
                Storage::delete('public/photos/users/' . $user->photo);
            }

            $file     = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/photos/users', $filename);
            $user->photo = $filename;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        // Hapus foto jika bukan default
        if ($user->photo && $user->photo != 'default.png') {
            Storage::delete('public/photos/users/' . $user->photo);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
