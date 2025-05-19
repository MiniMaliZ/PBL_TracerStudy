<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
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

    public function getAlumniData($nim) //mengambil data alumni untuk isi autofill
    {
        $alumni = Alumni::where('nim', $nim)->first();

        if ($alumni) {
            return response()->json([
                'nama_alumni' => $alumni->nama_alumni,
                'prodi' => $alumni->prodi,
                'tgl_lulus' => $alumni->tgl_lulus,
            ]);
        }

        return response()->json(null);
    }

    public function updatealumni(Request $requset, $nim) {
        Alumni::find($nim)->update([
            'no_hp'=>$requset->no_hp,
            'email'=>$requset->email,            
            'tahun_masuk'=>$requset->tahun_masuk,            
            'tanggal_kerja_pertama'=>$requset->tanggal_kerja_pertama,            
            'tanggal_mulai_instansi'=>$requset->tanggal_mulai_instansi,            
            'kategori_profesi'=>$requset->kategori_profesi,            
            'profesi'=>$requset->profesi,            
        ]);
    }




    //PenggunaLulusan----------------------------------------PenggunaLulusan----------------------------------PenggunaLulusan

    public function surveiPL()
    { // tracer study (Pengguna Lulusan)
        return view("FormTracerStudy.surveiPL");
    }
}
