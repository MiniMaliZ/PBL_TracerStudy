<?php

namespace App\Http\Controllers;

use App\Models\PenggunaLulusan;
use Illuminate\Http\Request;

class PenggunaLulusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penggunaLulusan = PenggunaLulusan::all();
        return view('admin.PenggunaLulusan.indexPenggunaLulusan', compact('penggunaLulusan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.PenggunaLulusan.createPenggunaLulusan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_atasan' => 'required|max:100',
            'jabatan_atasan' => 'required|max:100',
            'email_atasan' => 'nullable|email|max:100',
        ]);

        PenggunaLulusan::create($request->all());

        return redirect()->route('penggunaLulusan.index')
            ->with('success', 'Pengguna Lulusan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $penggunaLulusan = PenggunaLulusan::findOrFail($id);
        return view('admin.PenggunaLulusan.editPenggunaLulusan', compact('penggunaLulusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_atasan' => 'required|max:100',
            'jabatan_atasan' => 'required|max:100',
            'email_atasan' => 'nullable|email|max:100',
        ]);

        $penggunaLulusan = PenggunaLulusan::findOrFail($id);
        $penggunaLulusan->update($request->all());

        return redirect()->route('penggunaLulusan.index')
            ->with('success', 'Pengguna Lulusan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $penggunaLulusan = PenggunaLulusan::findOrFail($id);
        $penggunaLulusan->delete();

        return redirect()->route('penggunaLulusan.index')
            ->with('success', 'Pengguna Lulusan berhasil dihapus.');
    }
}