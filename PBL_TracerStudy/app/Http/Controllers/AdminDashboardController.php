<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Alumni;
use App\Models\Instansi;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // PROFESI
        $profesi = DB::table('alumni')
        ->join('profesi', 'alumni.id_profesi', '=', 'profesi.id_profesi')
        ->select('profesi.nama_profesi as profesi', DB::raw('count(*) as total'))
        ->whereNotNull('alumni.id_profesi')
        ->groupBy('profesi.nama_profesi')
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
            $instansi = DB::table('alumni')
        ->join('instansi', 'alumni.id_instansi', '=', 'instansi.id_instansi')
        ->select('instansi.jenis_instansi', DB::raw('count(*) as total'))
        ->groupBy('instansi.jenis_instansi')
        ->get();


        $instansiLabels = $instansi->pluck('jenis_instansi')->toArray();
        $instansiData = $instansi->pluck('total')->toArray();

        // KEPUASAN PENGGUNA LULUSAN (dinamis berdasarkan tabel pertanyaan kategori 'pengguna_lulusan')
        $pertanyaan = DB::table('pertanyaan')
            ->where('kategori', 'pengguna_lulusan')
            ->pluck('isi_pertanyaan', 'id_pertanyaan');

        $kriteriaChartData = [];
        foreach ($pertanyaan as $id => $label) {
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
        $sebaranLingkup = $this->getSebaranLingkupProfesiData();

        return view('admin.dashboard', compact(
            'profesiLabels',
            'profesiData',
            'instansiLabels',
            'instansiData',
            'masaTunggu',
            'sebaranLingkup',
            'kriteriaChartData'
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
            $jumlahTerlacak = (clone $alumniTahun)->whereNotNull('id_profesi')->count();
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
            ['No', 'Jenis Kemampuan', 'Sangat Kurang (%)', 'Kurang (%)', 'Cukup (%)', 'Baik (%)', 'Sangat Baik (%)']
        ], null, 'A1');

        // Mapping ID Pertanyaan ke Nama Kemampuan
        $kriteria = [
            4 => 'Kerjasama Tim',
            5 => 'Keahlian di bidang TI',
            6 => 'Kemampuan berbahasa asing (Inggris)',
            7 => 'Kemampuan berkomunikasi',
            8 => 'Pengembangan diri',
            9 => 'Kepemimpinan',
            10 => 'Etos Kerja',
        ];

        $kategoriLabel = [
            1 => 'Sangat Kurang',
            2 => 'Kurang',
            3 => 'Cukup',
            4 => 'Baik',
            5 => 'Sangat Baik',
        ];

        $rataRata = [
            'Sangat Kurang' => 0,
            'Kurang' => 0,
            'Cukup' => 0,
            'Baik' => 0,
            'Sangat Baik' => 0,
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
                $persentase[$label] = $persen;

                // Tambahkan ke total rata-rata
                $rataRata[$label] += $persen;
            }

            // Isi baris data ke sheet
            $sheet->fromArray([
                $no++,
                $namaKemampuan,
                $persentase['Sangat Kurang'],
                $persentase['Kurang'],
                $persentase['Cukup'],
                $persentase['Baik'],
                $persentase['Sangat Baik'],
            ], null, 'A' . $row++);
        }

        // Rata-rata
        $sheet->fromArray([
            '',
            'Jumlah Rata-Rata',
            round($rataRata['Sangat Kurang'] / $jumlahKemampuan, 2),
            round($rataRata['Kurang'] / $jumlahKemampuan, 2),
            round($rataRata['Cukup'] / $jumlahKemampuan, 2),
            round($rataRata['Baik'] / $jumlahKemampuan, 2),
            round($rataRata['Sangat Baik'] / $jumlahKemampuan, 2),
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


      protected function getSebaranLingkupProfesiData()
    {
        $tahunLulus = Alumni::selectRaw('YEAR(tgl_lulus) as tahun')
            ->whereNotNull('tgl_lulus')
            ->distinct()
            ->orderBy('tahun')
            ->pluck('tahun');

        $data = [];
        foreach ($tahunLulus as $tahun) {
            $alumniTahun = Alumni::with('instansi')->whereYear('tgl_lulus', $tahun);
            $jumlahLulusan = $alumniTahun->count();
            $terlacak = (clone $alumniTahun)->whereNotNull('id_profesi')->count();

            $alumniJoinProfesi = DB::table('alumni')
                ->join('profesi', 'alumni.id_profesi', '=', 'profesi.id_profesi')
                ->whereYear('tgl_lulus', $tahun);

            $bidangInfokom = (clone $alumniJoinProfesi)->where('profesi.kategori_profesi', 'Infokom')->count();
            $bidangNonInfokom = (clone $alumniJoinProfesi)->where('profesi.kategori_profesi', 'Non Infokom')->count();
            $wirausaha = (clone $alumniJoinProfesi)->where('profesi.kategori_profesi', 'Wirausaha')->count();

            $internasional = (clone $alumniTahun)->whereHas('instansi', fn($q) => $q->where('skala_instansi', 'Multinasional'))->count();
            $nasional = (clone $alumniTahun)->whereHas('instansi', fn($q) => $q->where('skala_instansi', 'Nasional'))->count();

            $data[] = [
                'tahun' => $tahun,
                'jumlah_lulusan' => $jumlahLulusan,
                'terlacak' => $terlacak,
                'infokom' => $bidangInfokom,
                'non_infokom' => $bidangNonInfokom,
                'internasional' => $internasional,
                'nasional' => $nasional,
                'wirausaha' => $wirausaha,
            ];
        }

        return $data;
    }
        public function exportLingkupKerja()
    {
        $data = $this->getSebaranLingkupProfesiData();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->fromArray([[
            'Tahun Lulus', 'Jumlah Lulusan', 'Jumlah Terlacak',
            'Kesesuaian Infokom', 'Kesesuaian Non Infokom',
            'Internasional', 'Nasional', 'Wirausaha'
        ]], null, 'A1');

        // Data rows
        $rowIndex = 2;
        foreach ($data as $row) {
            $sheet->fromArray([
                $row['tahun'],
                $row['jumlah_lulusan'],
                $row['terlacak'],
                $row['infokom'],
                $row['non_infokom'],
                $row['internasional'],
                $row['nasional'],
                $row['wirausaha'],
            ], null, 'A' . $rowIndex++);
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'Sebaran_Lingkup_Kerja_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
        public function exportMasaTunggu()
    {
        $data = $this->getMasaTungguTableData();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->fromArray([[
            'Tahun Lulus', 'Jumlah Lulusan', 'Jumlah Terlacak', 'Rata-rata Masa Tunggu (bulan)'
        ]], null, 'A1');

        // Data rows
        $rowIndex = 2;
        foreach ($data as $row) {
            $sheet->fromArray([
                $row['tahun_lulus'],
                $row['jumlah_lulusan'],
                $row['jumlah_terlacak'],
                number_format($row['rata_rata_masa_tunggu'], 2)
            ], null, 'A' . $rowIndex++);
        }

        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'Masa_Tunggu_Alumni_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

}
