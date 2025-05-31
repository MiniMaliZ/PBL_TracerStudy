<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Alumni;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // PROFESI
        $profesi = DB::table('alumni')
            ->select('profesi', DB::raw('count(*) as total'))
            ->groupBy('profesi')
            ->orderByDesc('total')
            ->get();

        $topProfesi = $profesi->take(10);
        $sisa = $profesi->skip(10)->sum('total');

        $profesiLabels = $topProfesi->pluck('profesi')->toArray();
        $profesiData = $topProfesi->pluck('total')->toArray();
        if ($sisa > 0) {
            $profesiLabels[] = 'Lainnya';
            $profesiData[] = $sisa;
        }

        // INSTANSI
        $instansi = DB::table('instansi')
            ->select('jenis_instansi', DB::raw('count(*) as total'))
            ->groupBy('jenis_instansi')
            ->get();

        $instansiLabels = $instansi->pluck('jenis_instansi')->toArray();
        $instansiData = $instansi->pluck('total')->toArray();

        // Kriteria Pertanyaan
        $kriteria = [
            1 => 'Kerjasama Tim',
            2 => 'Keahlian di bidang TI',
            3 => 'Kemampuan berbahasa asing (Inggris)',
            4 => 'Kemampuan berkomunikasi',
            5 => 'Pengembangan diri',
            6 => 'Kepemimpinan',
            7 => 'Etos Kerja',
        ];

        $kriteriaChartData = [];

        foreach ($kriteria as $id => $label) {
            $jawaban = DB::table('jawaban')
                ->select('jawaban', DB::raw('count(*) as total'))
                ->where('id_pertanyaan', $id)
                ->groupBy('jawaban')
                ->pluck('total', 'jawaban')
                ->toArray();

            $kriteriaChartData[$id] = [
                'label' => $label,
                'data' => [
                    'Sangat Kurang' => $jawaban[1] ?? 0,
                    'Kurang'        => $jawaban[2] ?? 0,
                    'Cukup'         => $jawaban[3] ?? 0,
                    'Baik'          => $jawaban[4] ?? 0,
                    'Sangat Baik'   => $jawaban[5] ?? 0,
                ]
            ];
        }

        $masaTunggu = $this->getMasaTungguTableData();

        return view('admin.dashboard', compact(
            'profesiLabels',
            'profesiData',
            'instansiLabels',
            'instansiData',
            'kriteriaChartData',
            'masaTunggu'
        ));
    }

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

        return $masaTunggu;
    }

    public function export_excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->fromArray([
            ['No', 'Jenis Kemampuan', 'Sangat Baik (%)', 'Baik (%)', 'Cukup (%)', 'Kurang (%)', 'Sangat Kurang (%)']
        ], null, 'A1');

        // Mapping ID Pertanyaan ke Nama Kemampuan
        $kriteria = [
            1 => 'Kerjasama Tim',
            2 => 'Keahlian di bidang TI',
            3 => 'Kemampuan berbahasa asing (Inggris)',
            4 => 'Kemampuan berkomunikasi',
            5 => 'Pengembangan diri',
            6 => 'Kepemimpinan',
            7 => 'Etos Kerja',
        ];

        $kategoriLabel = [
            5 => 'Sangat Baik',
            4 => 'Baik',
            3 => 'Cukup',
            2 => 'Kurang',
            1 => 'Sangat Kurang',
        ];

        $rataRata = [
            'Sangat Baik' => 0,
            'Baik' => 0,
            'Cukup' => 0,
            'Kurang' => 0,
            'Sangat Kurang' => 0,
        ];

        $row = 2;
        $no = 1;
        $jumlahKemampuan = count($kriteria);

        foreach ($kriteria as $idPertanyaan => $namaKemampuan) {
            $total = DB::table('jawaban')
                ->where('id_pertanyaan', $idPertanyaan)
                ->count();

            $persentase = [];

            foreach ($kategoriLabel as $nilai => $label) {
                $jumlah = DB::table('jawaban')
                    ->where('id_pertanyaan', $idPertanyaan)
                    ->where('jawaban', $nilai)
                    ->count();

                $persen = $total > 0 ? round(($jumlah / $total) * 100, 2) : 0;
                $persentase[] = $persen;

                // Tambahkan ke total rata-rata
                $rataRata[$label] += $persen;
            }

            $sheet->fromArray([
                $no++,
                $namaKemampuan,
                $persentase[0], // Sangat Baik
                $persentase[1], // Baik
                $persentase[2], // Cukup
                $persentase[3], // Kurang
                $persentase[4], // Sangat Kurang
            ], null, 'A' . $row++);
        }

        // Rata-rata
        $sheet->fromArray([
            '',
            'Jumlah Rata-Rata',
            round($rataRata['Sangat Baik'] / $jumlahKemampuan, 2),
            round($rataRata['Baik'] / $jumlahKemampuan, 2),
            round($rataRata['Cukup'] / $jumlahKemampuan, 2),
            round($rataRata['Kurang'] / $jumlahKemampuan, 2),
            round($rataRata['Sangat Kurang'] / $jumlahKemampuan, 2),
        ], null, 'A' . $row);

        // Auto size kolom
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'Kepuasan Pengguna Lulusan ' . now()->format('Y-m-d H-i-s') . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
