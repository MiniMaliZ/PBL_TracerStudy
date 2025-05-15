<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Instansi;
use App\Models\PenggunaLulusan;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class TCFormController extends Controller
{
    public function index()
    { // landingpage 
        return view("FormTracerStudy.index");
    }

    public function opsi()
    { //opsi form
        return view("FormTracerStudy.opsiform");
    }


    //Alumni----------------------------------------Alumni----------------------------------Alumni

    public function kusionerA()
    {
        // Ambil semua NIM dari model Alumni
        $nims = Alumni::pluck('nim'); // mengambil data 'nim' saja

        // Kirim data $nims ke view 'tracerstudy'
        return view("FormTracerStudy.tracerstudy", compact('nims'));
    }

    public function getAlumniData($keyword)
    {
        $alumni = Alumni::where('nim', 'LIKE', '%' . $keyword . '%')
            ->orWhere('nama_alumni', 'LIKE', '%' . $keyword . '%')
            ->first();

        if ($alumni) {
            return response()->json([
                'nama_alumni' => $alumni->nama_alumni,
                'nim' => $alumni->nim,
                'prodi' => $alumni->prodi,
                'tgl_lulus' => $alumni->tgl_lulus,
            ]);
        }

        return response()->json(null);
    }

    public function create_form(Request $request, $nim)
    {
        // Update data alumni
        $alumni = Alumni::find($nim);
        if (!$alumni) {
            return redirect()->back()->withErrors('Alumni tidak ditemukan.');
        }

        $alumni->update([
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'tahun_masuk' => $request->tahun_masuk,
            'tanggal_kerja_pertama' => $request->tanggal_kerja_pertama,
            'tanggal_mulai_instansi' => $request->tanggal_mulai_instansi,
            'kategori_profesi' => $request->kategori_profesi,
            'profesi' => $request->profesi,
        ]);

        // Cek apakah instansi sudah ada (berdasarkan nama & lokasi)
        $instansi = Instansi::where('nama_instansi', $request->nama_instansi)
            ->where('lokasi_instansi', $request->lokasi_instansi)
            ->first();

        // Jika tidak ada, buat baru
        if (!$instansi) {
            $instansi = Instansi::create([
                'nama_instansi' => $request->nama_instansi,
                'jenis_instansi' => $request->jenis_instansi,
                'skala_instansi' => $request->skala_instansi,
                'lokasi_instansi' => $request->lokasi_instansi,
                'no_hp_instansi' => $request->no_hp_instansi,
            ]);
        }

        // Cek apakah atasan sudah ada (berdasarkan email atasan)
        $atasan = PenggunaLulusan::where('email_atasan', $request->email_atasan)->first();

        // Jika tidak ada, buat baru
        if (!$atasan) {
            PenggunaLulusan::create([
                'nama_atasan' => $request->nama_atasan,
                'jabatan_atasan' => $request->jabatan_atasan,
                'email_atasan' => $request->email_atasan,
            ]);
        }

        return response()->json([
            'message' => 'Data berhasil disimpan.',
            'redirect' => url('/tracerstudy/formopsi'),
        ]);
    }




    //PenggunaLulusan----------------------------------------PenggunaLulusan----------------------------------PenggunaLulusan

    public function surveiPL()
    {
        // Ambil daftar nama atasan unik
        $namaAtasan = PenggunaLulusan::select('nama_atasan')->distinct()->get();
        $pertanyaan = Pertanyaan::all();

        return view("FormTracerStudy.surveiPL", compact('namaAtasan', 'pertanyaan'));
    }


    public function getPL($pl)
    {
        $penggunalulusan = PenggunaLulusan::where('nama_atasan', 'LIKE', '%' . $pl . '%')->first();

        if ($penggunalulusan) {
            return response()->json([
                'jabatan_atasan' => $penggunalulusan->jabatan_atasan,
                'email_atasan' => $penggunalulusan->email_atasan,
            ]);
        }

        return response()->json(null);
    }

    public function create_PL(Request $request) {}
}
