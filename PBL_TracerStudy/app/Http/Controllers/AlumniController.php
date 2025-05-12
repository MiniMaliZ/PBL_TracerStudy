<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\PenggunaLulusan;
use App\Models\Instansi;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    // Menampilkan data dalam tabel
    public function index()
    {
        // Ambil semua data alumni dengan relasi penggunaLulusan dan instansi
        $alumni = Alumni::with(['penggunaLulusan', 'instansi'])->get();

        return view('admin.Alumni.indexAlumni', compact('alumni'));
    }

    // Menampilkan form untuk tambah data
    public function create()
    {
        return view('admin.Alumni.createAlumni');
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:alumni,nim',
            'nama_alumni' => 'required|max:100',
            'prodi' => 'required|max:100',
            'tgl_lulus' => 'required|date',
            'tanggal_kerja_pertama' => 'nullable|date',
            'email' => 'nullable|email',
            'email_atasan' => 'nullable|email',
            'nama_instansi' => 'nullable|max:100',
            'jenis_instansi' => 'nullable|in:Pendidikan Tinggi,Instansi Pemerintah,BUMN,Perusahaan Swasta',
            'skala_instansi' => 'nullable|in:Wirausaha,Nasional,Multinasional',
        ]);

        // Cek atau buat data pengguna_lulusan
        $penggunaLulusan = PenggunaLulusan::updateOrCreate(
            ['email_atasan' => $request->email_atasan], // Cari berdasarkan email_atasan
            [
                'nama_atasan' => $request->nama_atasan,
                'jabatan_atasan' => $request->jabatan_atasan,
                'email_atasan' => $request->email_atasan,
            ]
        );

        // Cek atau buat data instansi
        $instansi = Instansi::updateOrCreate(
            ['nama_instansi' => $request->nama_instansi], // Cari berdasarkan nama_instansi
            [
                'jenis_instansi' => $request->jenis_instansi,
                'skala_instansi' => $request->skala_instansi,
                'lokasi_instansi' => $request->lokasi_instansi,
                'no_hp_instansi' => $request->no_hp_instansi,
            ]
        );

        // Hitung masa tunggu (dalam bulan) berdasarkan tgl_lulus dan tanggal_kerja_pertama
        $masaTunggu = null;
        if ($request->tgl_lulus && $request->tanggal_kerja_pertama) {
            $masaTunggu = \Carbon\Carbon::parse($request->tgl_lulus)
                ->diffInMonths(\Carbon\Carbon::parse($request->tanggal_kerja_pertama), false); // False untuk hasil negatif
        }

        // Simpan data alumni
        Alumni::create([
            'nim' => $request->nim,
            'nama_alumni' => $request->nama_alumni,
            'prodi' => $request->prodi,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'tahun_masuk' => $request->tahun_masuk,
            'tgl_lulus' => $request->tgl_lulus,
            'tanggal_kerja_pertama' => $request->tanggal_kerja_pertama,
            'tanggal_mulai_instansi' => $request->tanggal_mulai_instansi,
            'masa_tunggu' => $masaTunggu,
            'kategori_profesi' => $request->kategori_profesi,
            'profesi' => $request->profesi,
            'id_pengguna_lulusan' => $penggunaLulusan->id_pengguna_lulusan,
            'id_instansi' => $instansi->id_instansi,
        ]);

        return redirect()->route('alumni.index')->with('success', 'Data alumni berhasil ditambahkan.');
    }

    // Menampilkan form untuk edit data
    public function edit($nim)
    {
        // Ambil data alumni berdasarkan nim dengan relasi penggunaLulusan dan instansi
        $alumni = Alumni::with(['penggunaLulusan', 'instansi'])->findOrFail($nim);

        return view('admin.Alumni.editAlumni', compact('alumni'));
    }

    // Memperbarui data
    public function update(Request $request, $nim)
    {
        $request->validate([
            'nama_alumni' => 'required|max:100',
            'prodi' => 'required|max:100',
            'tgl_lulus' => 'required|date',
            'tanggal_kerja_pertama' => 'nullable|date',
            'email' => 'nullable|email',
            'email_atasan' => 'nullable|email',
            'nama_instansi' => 'nullable|max:100',
            'jenis_instansi' => 'nullable|in:Pendidikan Tinggi,Instansi Pemerintah,BUMN,Perusahaan Swasta',
            'skala_instansi' => 'nullable|in:Wirausaha,Nasional,Multinasional',
        ]);

        $alumni = Alumni::findOrFail($nim);

        // Cek atau buat data pengguna_lulusan
        $penggunaLulusan = PenggunaLulusan::updateOrCreate(
            ['email_atasan' => $request->email_atasan], // Cari berdasarkan email_atasan
            [
                'nama_atasan' => $request->nama_atasan,
                'jabatan_atasan' => $request->jabatan_atasan,
                'email_atasan' => $request->email_atasan,
            ]
        );

        // Cek atau buat data instansi
        $instansi = Instansi::updateOrCreate(
            ['nama_instansi' => $request->nama_instansi], // Cari berdasarkan nama_instansi
            [
                'jenis_instansi' => $request->jenis_instansi,
                'skala_instansi' => $request->skala_instansi,
                'lokasi_instansi' => $request->lokasi_instansi,
                'no_hp_instansi' => $request->no_hp_instansi,
            ]
        );

        // Hitung masa tunggu (dalam bulan) berdasarkan tgl_lulus dan tanggal_kerja_pertama
        $masaTunggu = null;
        if ($request->tgl_lulus && $request->tanggal_kerja_pertama) {
            $masaTunggu = \Carbon\Carbon::parse($request->tgl_lulus)
                ->diffInMonths(\Carbon\Carbon::parse($request->tanggal_kerja_pertama), false); // False untuk hasil negatif
        }

        // Update data alumni
        $alumni->update([
            'nama_alumni' => $request->nama_alumni,
            'prodi' => $request->prodi,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'tahun_masuk' => $request->tahun_masuk,
            'tgl_lulus' => $request->tgl_lulus,
            'tanggal_kerja_pertama' => $request->tanggal_kerja_pertama,
            'tanggal_mulai_instansi' => $request->tanggal_mulai_instansi,
            'masa_tunggu' => $masaTunggu,
            'kategori_profesi' => $request->kategori_profesi,
            'profesi' => $request->profesi,
            'id_pengguna_lulusan' => $penggunaLulusan->id_pengguna_lulusan,
            'id_instansi' => $instansi->id_instansi,
        ]);

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