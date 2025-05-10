<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    // Menampilkan data dalam tabel
    public function index()
    {
        $alumni = Alumni::all(); // Ambil semua data alumni
        return view('admin.Alumni.indexAlumni', compact('alumni')); // Sesuaikan path
    }

    // Menampilkan form untuk tambah data
    public function create()
    {
        return view('admin.Alumni.createAlumni'); // Sesuaikan path
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:alumni,nim',
            'nama_alumni' => 'required',
            'prodi' => 'required',
            'email' => 'required|email',
        ]);

        Alumni::create($request->all());

        return redirect()->route('alumni.index')->with('success', 'Data alumni berhasil ditambahkan.');
    }

    // Menampilkan form untuk edit data
    public function edit($nim)
    {
        $alumni = Alumni::findOrFail($nim);
        return view('admin.Alumni.editAlumni', compact('alumni')); // Sesuaikan path
    }

    // Memperbarui data
    public function update(Request $request, $nim)
    {
        $request->validate([
            'nama_alumni' => 'required',
            'prodi' => 'required',
            'email' => 'required|email',
        ]);

        $alumni = Alumni::findOrFail($nim);
        $alumni->update($request->all());

        return redirect()->route('alumni.index')->with('success', 'Data alumni berhasil diperbarui.');
    }

    // Menghapus data
    public function destroy($nim)
    {
        $alumni = Alumni::findOrFail($nim);
        $alumni->delete();

        return redirect()->route('alumni.index')->with('success', 'Data alumni berhasil dihapus.');
    }
}