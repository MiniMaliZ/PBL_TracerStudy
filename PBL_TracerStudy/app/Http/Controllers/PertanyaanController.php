<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use App\Models\Admin;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    // Menampilkan data dalam tabel
    public function index()
    {
        // Ambil data pertanyaan beserta relasi admin
        $pertanyaan = Pertanyaan::with('admin')->get();
        return view('admin.tables', compact('pertanyaan'));
    }

    // Menampilkan form untuk tambah data
    public function create()
    {
        $admins = Admin::all(); // Ambil semua admin untuk dropdown
        return view('admin.create', compact('admins'));
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'isi_pertanyaan' => 'required',
            'kategori' => 'required',
            'created_by' => 'required|exists:admin,id_admin',
        ]);

        Pertanyaan::create($request->all());

        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    // Menampilkan form untuk edit data
    public function edit($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id); // Cari data berdasarkan ID
        return view('admin.edit', compact('pertanyaan'));
    }

    // Memperbarui data
    public function update(Request $request, $id)
    {
        $request->validate([
            'isi_pertanyaan' => 'required',
            'kategori' => 'required',
        ]);

        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->update($request->all());

        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    // Menghapus data
    public function destroy($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->delete();

        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }
}