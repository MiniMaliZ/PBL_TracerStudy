<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('admin.Admin.indexAdmin', compact('admins'));
    }

    public function create()
    {
        return view('admin.Admin.createAdmin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admin,username|max:50',
            'password' => 'required|min:6', // Validasi password minimal 6 karakter
            'nama' => 'required|max:100',
        ], [
            'password.min' => 'Password harus memiliki minimal 6 karakter.', // Pesan error khusus
        ]);

        Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password), // Hash password
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.Admin.editAdmin', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'username' => 'required|max:50|unique:admin,username,' . $id . ',id_admin',
            'nama' => 'required|max:100',
        ]);

        $data = [
            'username' => $request->username,
            'nama' => $request->nama,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6', // Validasi password minimal 6 karakter
            ], [
                'password.min' => 'Password harus memiliki minimal 6 karakter.', // Pesan error khusus
            ]);
            $data['password'] = Hash::make($request->password); // Hash password baru
        }

        $admin->update($data);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus.');
    }
}