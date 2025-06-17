<?php

namespace App\Http\Controllers;

use App\Models\PenggunaLulusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

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

    public function export()
    {
        // Ambil data pengguna lulusan dengan alumni yang datanya lengkap tapi belum dinilai
        $penggunaLulusan = PenggunaLulusan::with(['alumni' => function ($query) {
            // Filter alumni yang datanya sudah lengkap dan belum ada di tabel jawaban
            $query->whereNotNull('nama_alumni')
                ->whereNotNull('prodi')
                ->whereNotNull('no_hp')
                ->whereNotNull('email')
                ->whereNotNull('tahun_masuk')
                ->whereNotNull('tgl_lulus')
                ->whereNotNull('tanggal_kerja_pertama')
                ->whereNotNull('tanggal_mulai_instansi')
                ->whereNotNull('masa_tunggu')
                ->whereNotNull('kategori_profesi')
                ->whereNotNull('profesi')
                ->whereNotNull('id_pengguna_lulusan')
                ->whereNotNull('id_instansi')
                ->where('nama_alumni', '!=', '')
                ->where('prodi', '!=', '')
                ->where('no_hp', '!=', '')
                ->where('email', '!=', '')
                ->where('profesi', '!=', '')
                ->whereDoesntHave('jawaban') // Belum ada di tabel jawaban
                ->with('instansi');
        }])->get();

        // Filter hanya pengguna lulusan yang memiliki alumni dengan data lengkap tapi belum dinilai
        $penggunaLulusan = $penggunaLulusan->filter(function ($pengguna) {
            return $pengguna->alumni->isNotEmpty();
        });

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header sesuai gambar
        $headers = ['Nama', 'Instansi', 'Jabatan', 'No HP', 'Email', 'Nama Alumni', 'Program Studi', 'Tahun Lulus'];
        $sheet->fromArray($headers, null, 'A1');

        // Style untuk header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFCCCCCC',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Auto width untuk semua kolom
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Isi data
        $row = 2;
        foreach ($penggunaLulusan as $pengguna) {
            // Tampilkan setiap alumni yang datanya lengkap tapi belum dinilai
            foreach ($pengguna->alumni as $alumni) {
                // Ambil tahun dari tgl_lulus
                $tahunLulus = '-';
                if ($alumni->tgl_lulus) {
                    $tahunLulus = date('Y', strtotime($alumni->tgl_lulus));
                }

                $data = [
                    $pengguna->nama_atasan ?? '-',
                    $alumni->instansi->nama_instansi ?? '-',
                    $pengguna->jabatan_atasan ?? '-',
                    $alumni->no_hp ?? '-',
                    $pengguna->email_atasan ?? '-',
                    $alumni->nama_alumni ?? '-',
                    $alumni->prodi ?? '-',
                    $tahunLulus
                ];
                $sheet->fromArray($data, null, 'A' . $row);
                $row++;
            }
        }

        // Jika tidak ada data
        if ($row == 2) {
            $sheet->setCellValue('A2', 'Tidak ada alumni dengan data lengkap yang belum dinilai');
            $sheet->mergeCells('A2:H2');
            $row = 3;
        }

        // Set border untuk semua data
        if ($row > 2) {
            $dataRange = 'A1:H' . ($row - 1);
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ]);
        }

        // Buat writer dan download
        $writer = new Xlsx($spreadsheet);
        $filename = 'alumni_data_lengkap_belum_dinilai_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Set headers untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function exportSudahIsiSurvey()
    {
        // TAMBAHKAN QUERY INI YANG HILANG!
        $penggunaLulusan = PenggunaLulusan::with(['alumni' => function ($query) {
            // Filter alumni yang datanya sudah lengkap dan sudah ada di tabel jawaban
            $query->whereNotNull('nama_alumni')
                ->whereNotNull('prodi')
                ->whereNotNull('no_hp')
                ->whereNotNull('email')
                ->whereNotNull('tahun_masuk')
                ->whereNotNull('tgl_lulus')
                ->whereNotNull('tanggal_kerja_pertama')
                ->whereNotNull('tanggal_mulai_instansi')
                ->whereNotNull('masa_tunggu')
                ->whereNotNull('kategori_profesi')
                ->whereNotNull('profesi')
                ->whereNotNull('id_pengguna_lulusan')
                ->whereNotNull('id_instansi')
                ->where('nama_alumni', '!=', '')
                ->where('prodi', '!=', '')
                ->where('no_hp', '!=', '')
                ->where('email', '!=', '')
                ->where('profesi', '!=', '')
                ->whereIn('nim', function ($subQuery) {
                    $subQuery->select('nim_alumni')
                        ->from('jawaban')
                        ->whereNotNull('nim_alumni');
                })
                ->with('instansi');
        }])->get();

        // Filter hanya pengguna lulusan yang memiliki alumni dengan data lengkap dan sudah dinilai
        $penggunaLulusan = $penggunaLulusan->filter(function ($pengguna) {
            return $pengguna->alumni->isNotEmpty();
        });

        // Ambil semua pertanyaan secara dinamis
        $pertanyaanPenilaian = DB::table('pertanyaan')
            ->where('metodejawaban', 1)
            ->orderBy('id_pertanyaan')
            ->get();

        $pertanyaanMasukan = DB::table('pertanyaan')
            ->where('metodejawaban', 2)
            ->orderBy('id_pertanyaan')
            ->get();

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header dinamis
        $headers = [
            'Nama',
            'Instansi',
            'Jabatan',
            'No HP',
            'Email',
            'Nama Alumni',
            'Program Studi',
            'Tahun Lulus'
        ];

        // Tambahkan header pertanyaan penilaian secara dinamis
        foreach ($pertanyaanPenilaian as $itemPenilaian) {
            $headers[] = $itemPenilaian->isi_pertanyaan;
        }

        // Tambahkan header pertanyaan masukan secara dinamis
        foreach ($pertanyaanMasukan as $itemMasukan) {
            $headers[] = $itemMasukan->isi_pertanyaan;
        }

        $sheet->fromArray($headers, null, 'A1');

        // Style untuk header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFCCCCCC',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $lastColumn = chr(65 + count($headers) - 1);
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray($headerStyle);

        // Auto width untuk semua kolom
        for ($i = 0; $i < count($headers); $i++) {
            $column = chr(65 + $i);
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Function untuk convert angka ke text penilaian
        $convertRating = function ($rating) {
            switch ($rating) {
                case 1:
                    return 'Sangat Kurang';
                case 2:
                    return 'Kurang';
                case 3:
                    return 'Cukup';
                case 4:
                    return 'Baik';
                case 5:
                    return 'Sangat Baik';
                default:
                    return '-';
            }
        };

        // Isi data
        $row = 2;
        foreach ($penggunaLulusan as $pengguna) {
            foreach ($pengguna->alumni as $alumni) {
                // Ambil tahun dari tgl_lulus
                $tahunLulus = '-';
                if ($alumni->tgl_lulus) {
                    $tahunLulus = date('Y', strtotime($alumni->tgl_lulus));
                }

                // Ambil semua jawaban untuk alumni ini
                $jawabanPenilaian = DB::table('jawaban')
                    ->join('pertanyaan', 'jawaban.id_pertanyaan', '=', 'pertanyaan.id_pertanyaan')
                    ->where('jawaban.nim_alumni', $alumni->nim)
                    ->where('pertanyaan.metodejawaban', 1)
                    ->select('pertanyaan.id_pertanyaan', 'jawaban.jawaban')
                    ->get()
                    ->keyBy('id_pertanyaan');

                $jawabanMasukan = DB::table('jawaban')
                    ->join('pertanyaan', 'jawaban.id_pertanyaan', '=', 'pertanyaan.id_pertanyaan')
                    ->where('jawaban.nim_alumni', $alumni->nim)
                    ->where('pertanyaan.metodejawaban', 2)
                    ->select('pertanyaan.id_pertanyaan', 'jawaban.jawaban')
                    ->get()
                    ->keyBy('id_pertanyaan');

                // Data dasar
                $data = [
                    $pengguna->nama_atasan ?? '-',
                    $alumni->instansi->nama_instansi ?? '-',
                    $pengguna->jabatan_atasan ?? '-',
                    $alumni->no_hp ?? '-',
                    $pengguna->email_atasan ?? '-',
                    $alumni->nama_alumni ?? '-',
                    $alumni->prodi ?? '-',
                    $tahunLulus,
                ];

                // Tambahkan jawaban penilaian secara dinamis
                foreach ($pertanyaanPenilaian as $penilaianItem) {
                    $jawaban = null;
                    if (isset($jawabanPenilaian[$penilaianItem->id_pertanyaan])) {
                        $jawaban = $jawabanPenilaian[$penilaianItem->id_pertanyaan]->jawaban;
                    }
                    $data[] = $convertRating($jawaban);
                }

                // Tambahkan jawaban masukan secara dinamis
                foreach ($pertanyaanMasukan as $masukanItem) {
                    $jawaban = '-';
                    if (isset($jawabanMasukan[$masukanItem->id_pertanyaan])) {
                        $jawaban = $jawabanMasukan[$masukanItem->id_pertanyaan]->jawaban;
                    }
                    $data[] = $jawaban;
                }

                $sheet->fromArray($data, null, 'A' . $row);
                $row++;
            }
        }

        // Jika tidak ada data
        if ($row == 2) {
            $sheet->setCellValue('A2', 'Tidak ada alumni yang sudah dinilai');
            $sheet->mergeCells('A2:' . $lastColumn . '2');
            $row = 3;
        }

        // Set border untuk semua data
        if ($row > 2) {
            $dataRange = 'A1:' . $lastColumn . ($row - 1);
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ]);
        }

        // Buat writer dan download
        $writer = new Xlsx($spreadsheet);
        $filename = 'alumni_sudah_dinilai_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Set headers untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
