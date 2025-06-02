<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\PenggunaLulusan;
use App\Models\Instansi;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
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
    public function import()
    {
        return view('admin.Alumni.indexAlumni');
    }

public function import_ajax(Request $request)
{
    $validator = Validator::make($request->all(), [
        'file_alumni' => ['required', 'file', 'mimes:xlsx', 'max:1024']
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $file = $request->file('file_alumni');
    $reader = IOFactory::createReader('Xlsx');
    $spreadsheet = $reader->load($file->getRealPath());
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray(null, true, true, true);

    $insert = [];
    foreach ($data as $i => $row) {
        if ($i == 1) continue; // skip header

        $tgl_lulus = $this->convertExcelDate($row['D'] ?? null);

        $insert[] = [
            'nim' => $row['A'],
            'nama_alumni' => $row['B'],
            'prodi' => $row['C'],
            'tgl_lulus' => $tgl_lulus,
        ];
    }

    if (!empty($insert)) {
        Alumni::insertOrIgnore($insert);
        return redirect()->back()->with('success', 'Data berhasil diimpor.');
    }

    return redirect()->back()->with('error', 'Tidak ada data yang diimpor.');
}


    // Tambahkan fungsi bantu ini dalam controller
    private function convertExcelDate($value)
    {
        if (!$value) return null;

        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            } else {
                return \Carbon\Carbon::parse($value)->format('Y-m-d');
            }
        } catch (\Exception $e) {
            return null;
        }
    }

        public function export_excel(Request $request)
    {
        $status = $request->status;

        if (!in_array($status, ['sudah', 'belum'])) {
            return redirect()->back()->with('error', 'Status tidak valid atau belum dipilih.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // ======================== JIKA BELUM MENGISI ========================
        if ($status === 'belum') {
            $alumni = Alumni::whereNull('tanggal_kerja_pertama')->orderBy('prodi')->get();

            // Header
            $header = ['Program Studi', 'NIM', 'Nama', 'Tanggal Lulus'];
            $sheet->fromArray([$header], null, 'A1');
            $sheet->getStyle('A1:D1')->getFont()->setBold(true);
            $sheet->getStyle('A1:D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row = 2;
            foreach ($alumni as $item) {
                $sheet->fromArray([
                    $item->prodi,
                    $item->nim,
                    $item->nama_alumni,
                    $item->tgl_lulus,
                ], null, 'A' . $row);

                $sheet->getStyle("A{$row}:D{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $row++;
            }

            foreach (range('A', 'D') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        }

        // ======================== JIKA SUDAH MENGISI ========================
        else {
            $alumni = Alumni::with('instansi')
                ->whereNotNull('tanggal_kerja_pertama')
                ->orderBy('prodi')
                ->get();

            $header = [
                'Program Studi', 'NIM', 'Nama', 'No.HP', 'Email',
                'Tanggal Lulus', 'Tahun Masuk', 'Tanggal Pertama Kerja', 'Masa Tunggu',
                'Tgl Mulai Kerja Instansi Saat Ini', 'Jenis Instansi', 'Nama Instansi',
                'Skala', 'Lokasi Instansi', 'Kategori Profesi', 'Profesi'
            ];

            $sheet->fromArray([$header], null, 'A1');
            $sheet->getStyle('A1:P1')->getFont()->setBold(true);
            $sheet->getStyle('A1:P1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row = 2;
            foreach ($alumni as $item) {
                $instansi = $item->instansi;

                $masa_tunggu = null;
                if ($item->tgl_lulus && $item->tanggal_kerja_pertama) {
                    try {
                        $masa_tunggu = \Carbon\Carbon::parse($item->tgl_lulus)->diffInDays(\Carbon\Carbon::parse($item->tanggal_kerja_pertama));
                    } catch (\Exception $e) {
                        $masa_tunggu = null;
                    }
                }

                $sheet->fromArray([
                    $item->prodi,
                    $item->nim,
                    $item->nama_alumni,
                    $item->no_hp,
                    $item->email,
                    $item->tgl_lulus,
                    $item->tahun_masuk,
                    $item->tanggal_kerja_pertama,
                    $masa_tunggu,
                    $item->tanggal_mulai_instansi,
                    $instansi->jenis_instansi ?? '',
                    $instansi->nama_instansi ?? '',
                    $instansi->skala_instansi ?? '',
                    $instansi->lokasi_instansi ?? '',
                    $item->kategori_profesi,
                    $item->profesi,
                ], null, 'A' . $row);

                $sheet->getStyle("A{$row}:P{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $row++;
            }

            foreach (range('A', 'P') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        }

        // ======================== EXPORT ========================
        $filename = 'Data Alumni ' . ucfirst($status) . ' Mengisi - ' . now()->format('Y-m-d H-i-s') . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}