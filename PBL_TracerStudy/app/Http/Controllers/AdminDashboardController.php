<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $masaTunggu = $this->getMasaTungguTableData();
        return view('admin.dashboard', compact('masaTunggu'));
    }

    /**
     * Ambil data tabel rata-rata masa tunggu alumni per tahun lulus.
     */
    protected function getMasaTungguTableData()
    {
        $tahunLulus = Alumni::selectRaw('YEAR(tgl_lulus) as tahun')
            ->whereNotNull('tgl_lulus')
            ->orderBy('tahun')
            ->distinct()
            ->pluck('tahun');

        $masaTunggu = [];
        foreach ($tahunLulus as $tahun) {
            $alumniTahun = Alumni::whereYear('tgl_lulus', $tahun);
            $jumlahLulusan = $alumniTahun->count();
            $jumlahTerlacak = (clone $alumniTahun)->whereNotNull('profesi')->count();
            $pengisiMasaTunggu = (clone $alumniTahun)->whereNotNull('tanggal_kerja_pertama')->count();
            $totalMasaTunggu = (clone $alumniTahun)->whereNotNull('tanggal_kerja_pertama')->sum('masa_tunggu');
            $rataRataMasaTunggu = $pengisiMasaTunggu > 0 ? $totalMasaTunggu / $pengisiMasaTunggu : 0;

            $masaTunggu[] = [
                'tahun_lulus' => $tahun,
                'jumlah_lulusan' => $jumlahLulusan,
                'jumlah_terlacak' => $jumlahTerlacak,
                'rata_rata_masa_tunggu' => $rataRataMasaTunggu,
                'total_masa_tunggu' => $totalMasaTunggu,
                'pengisi_masa_tunggu' => $pengisiMasaTunggu,
            ];
        }

        // dd($masaTunggu);
        return $masaTunggu;
    }
}
