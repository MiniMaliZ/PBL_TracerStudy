{{-- filepath: c:\laragon\www\PBL_TracerStudy\PBL_TracerStudy\resources\views\admin\Alumni\indexAlumni.blade.php --}}
@extends('layouts.template')

@section('title', 'Data Alumni')

@section('content')
    <div class="card">
        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Show import errors --}}
        @if (session('import_errors'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h6>Detail Error Import:</h6>
                <ul class="mb-0">
                    @foreach (session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Header Card --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-0">Data Alumni</h4>
                @if (request()->anyFilled([
                        'search',
                        'filter_prodi',
                        'filter_jurusan',
                        'filter_tahun_masuk',
                        'filter_profesi',
                        'filter_status',
                        'filter_tahun_lulus',
                    ]))
                    <small class="text-muted">
                        <i class="fas fa-filter"></i> Menampilkan {{ $alumni->count() }} dari total alumni (Terfilter)
                    </small>
                @else
                    <small class="text-muted">Menampilkan {{ $alumni->count() }} total alumni</small>
                @endif
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('alumni.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalImport">
                    <i class="fas fa-file-import"></i> Import Alumni
                </button>

                {{-- Dropdown Download --}}
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownExport"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-download"></i> Download
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownExport">
                        <li>
                            <h6 class="dropdown-header">Template</h6>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('alumni.template') }}">
                                <i class="fas fa-file-excel text-success"></i> Template Import
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <h6 class="dropdown-header">Export Data</h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="exportData('semua')">
                                <i class="fas fa-users text-primary"></i> Semua Alumni
                                @if (request()->anyFilled([
                                        'search',
                                        'filter_prodi',
                                        'filter_jurusan',
                                        'filter_tahun_masuk',
                                        'filter_profesi',
                                        'filter_tahun_lulus',
                                    ]))
                                    <small class="text-muted">({{ $alumni->count() }} data terfilter)</small>
                                @else
                                    <small class="text-muted">({{ $alumni->count() }} data)</small>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="exportData('sudah')">
                                <i class="fas fa-user-check text-success"></i> Alumni Sudah Mengisi Lengkap
                                <small class="text-muted">
                                    ({{ $alumni->filter(function ($item) {
                                            return !is_null($item->no_hp) &&
                                                !is_null($item->email) &&
                                                !is_null($item->tanggal_kerja_pertama) &&
                                                !is_null($item->tanggal_mulai_instansi) &&
                                                !is_null($item->masa_tunggu) &&
                                                !is_null($item->id_profesi) &&
                                                !is_null($item->id_pengguna_lulusan) &&
                                                !is_null($item->id_instansi) &&
                                                trim($item->no_hp) !== '' &&
                                                trim($item->email) !== '';
                                        })->count() }}
                                    data)
                                </small>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="exportData('belum')">
                                <i class="fas fa-user-times text-warning"></i> Alumni Belum Mengisi Lengkap
                                <small class="text-muted">
                                    ({{ $alumni->filter(function ($item) {
                                            return is_null($item->no_hp) ||
                                                is_null($item->email) ||
                                                is_null($item->tanggal_kerja_pertama) ||
                                                is_null($item->tanggal_mulai_instansi) ||
                                                is_null($item->masa_tunggu) ||
                                                is_null($item->id_profesi) ||
                                                is_null($item->id_pengguna_lulusan) ||
                                                is_null($item->id_instansi) ||
                                                trim($item->no_hp ?? '') === '' ||
                                                trim($item->email ?? '') === '';
                                        })->count() }}
                                    data)
                                </small>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Body Card --}}
        <div class="card-body">
            {{-- Statistics Cards dengan kriteria baru --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="text-primary">{{ $alumni->count() }}</h5>
                            <p class="mb-0 text-muted">Total
                                Alumni{{ request()->anyFilled(['search', 'filter_prodi']) ? ' (Terfilter)' : '' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="text-success">
                                {{-- Kriteria baru: SEMUA field harus terisi --}}
                                {{ $alumni->filter(function ($item) {
                                        return !is_null($item->no_hp) &&
                                            !is_null($item->email) &&
                                            !is_null($item->tanggal_kerja_pertama) &&
                                            !is_null($item->tanggal_mulai_instansi) &&
                                            !is_null($item->masa_tunggu) &&
                                            !is_null($item->id_profesi) &&
                                            !is_null($item->id_pengguna_lulusan) &&
                                            !is_null($item->id_instansi) &&
                                            trim($item->no_hp) !== '' &&
                                            trim($item->email) !== '';
                                    })->count() }}
                            </h5>
                            <p class="mb-0 text-muted">Sudah Mengisi Lengkap</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="text-warning">
                                {{-- Kriteria baru: Ada minimal 1 field yang kosong --}}
                                {{ $alumni->filter(function ($item) {
                                        return is_null($item->no_hp) ||
                                            is_null($item->email) ||
                                            is_null($item->tanggal_kerja_pertama) ||
                                            is_null($item->tanggal_mulai_instansi) ||
                                            is_null($item->masa_tunggu) ||
                                            is_null($item->id_profesi) ||
                                            is_null($item->id_pengguna_lulusan) ||
                                            is_null($item->id_instansi) ||
                                            trim($item->no_hp ?? '') === '' ||
                                            trim($item->email ?? '') === '';
                                    })->count() }}
                            </h5>
                            <p class="mb-0 text-muted">Belum Mengisi Lengkap</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="text-info">
                                {{-- Rata-rata kelengkapan data --}}
                                @php
                                    $totalCompletion = 0;
                                    $totalAlumni = $alumni->count();

                                    if ($totalAlumni > 0) {
                                        foreach ($alumni as $item) {
                                            $requiredFields = [
                                                'no_hp',
                                                'email',
                                                'tanggal_kerja_pertama',
                                                'tanggal_mulai_instansi',
                                                'masa_tunggu',
                                                'id_profesi',
                                                'id_pengguna_lulusan',
                                                'id_instansi',
                                            ];
                                            $completedFields = 0;

                                            foreach ($requiredFields as $field) {
                                                if (!is_null($item->$field) && trim($item->$field) !== '') {
                                                    $completedFields++;
                                                }
                                            }

                                            $totalCompletion += ($completedFields / count($requiredFields)) * 100;
                                        }

                                        $avgCompletion = round($totalCompletion / $totalAlumni, 1);
                                    } else {
                                        $avgCompletion = 0;
                                    }
                                @endphp
                                {{ $avgCompletion }}%
                            </h5>
                            <p class="mb-0 text-muted">Rata-rata Kelengkapan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Include Search & Filter Component --}}
    @include('admin.Alumni.search-filter')

    {{-- Data Table Card --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-items-center mb-0" id="alumniTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Alumni</th>
                            <th>Prodi</th>
                            <th>Jurusan</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Tahun Masuk</th>
                            <th>Tanggal Lulus</th>
                            <th>Profesi</th>
                            <th>Instansi</th>
                            <th>Masa Tunggu</th>
                            <th>Kelengkapan</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($alumni as $item)
                            @php
                                // Kriteria baru: SEMUA field harus terisi
                                $sudahLengkap =
                                    !is_null($item->no_hp) &&
                                    !is_null($item->email) &&
                                    !is_null($item->tanggal_kerja_pertama) &&
                                    !is_null($item->tanggal_mulai_instansi) &&
                                    !is_null($item->masa_tunggu) &&
                                    !is_null($item->id_profesi) &&
                                    !is_null($item->id_pengguna_lulusan) &&
                                    !is_null($item->id_instansi) &&
                                    trim($item->no_hp) !== '' &&
                                    trim($item->email) !== '';

                                // Hitung persentase kelengkapan
                                $requiredFields = [
                                    'no_hp',
                                    'email',
                                    'tanggal_kerja_pertama',
                                    'tanggal_mulai_instansi',
                                    'masa_tunggu',
                                    'id_profesi',
                                    'id_pengguna_lulusan',
                                    'id_instansi',
                                ];
                                $completedFields = 0;

                                foreach ($requiredFields as $field) {
                                    if (!is_null($item->$field) && trim($item->$field) !== '') {
                                        $completedFields++;
                                    }
                                }

                                $completionPercentage = round(($completedFields / count($requiredFields)) * 100);
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $item->nim }}</strong></td>
                                <td>{{ $item->nama_alumni }}</td>
                                <td>{{ $item->prodi->nama_prodi ?? '-' }}</td>
                                <td>{{ $item->prodi->jurusan ?? '-' }}</td>
                                <td>{{ $item->no_hp ?? '-' }}</td>
                                <td>{{ $item->email ?? '-' }}</td>
                                <td>{{ $item->tahun_masuk ?? '-' }}</td>
                                <td>{{ $item->tgl_lulus ? \Carbon\Carbon::parse($item->tgl_lulus)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $item->profesi->nama_profesi ?? '-' }}</td>
                                <td>{{ $item->instansi->nama_instansi ?? '-' }}</td>
                                <td>
                                    @if ($item->masa_tunggu !== null)
                                        <span
                                            class="badge bg-{{ $item->masa_tunggu <= 6 ? 'success' : ($item->masa_tunggu <= 12 ? 'warning' : 'danger') }}">
                                            {{ $item->masa_tunggu }} bulan
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    {{-- Progress bar kelengkapan --}}
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 8px;">
                                            <div class="progress-bar bg-{{ $completionPercentage == 100 ? 'success' : ($completionPercentage >= 50 ? 'warning' : 'danger') }}"
                                                role="progressbar" style="width: {{ $completionPercentage }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $completionPercentage }}%</small>
                                    </div>
                                </td>
                                <td>
                                    @if ($sudahLengkap)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Lengkap
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Belum Lengkap
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('alumni.edit', $item->nim) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('alumni.destroy', $item->nim) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Tidak ada data yang ditemukan</h5>
                                        <p class="text-muted">Coba ubah kriteria pencarian atau filter Anda</p>
                                        <a href="{{ route('alumni.index') }}" class="btn btn-primary">
                                            <i class="fas fa-undo"></i> Reset Filter
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Include Modal Import --}}
    @include('admin.Alumni.import')

    {{-- Include jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- Include SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- JavaScript untuk Export dan DataTable --}}
    <script>
        // Function untuk export data dengan mempertahankan filter
        function exportData(status) {
            // Get current URL parameters (filters)
            const urlParams = new URLSearchParams(window.location.search);
            
            // Add status parameter
            urlParams.set('status', status);
            
            // Build export URL
            const exportUrl = "{{ route('alumni.export') }}" + '?' + urlParams.toString();
            
            // Show loading indication
            Swal.fire({
                title: 'Memproses Export...',
                text: 'Mohon tunggu, sedang mempersiapkan file Excel',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Create hidden link and trigger download
            const link = document.createElement('a');
            link.href = exportUrl;
            link.style.display = 'none';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Close loading after delay
            setTimeout(() => {
                Swal.close();
                
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Export Berhasil!',
                    text: 'File Excel telah diunduh',
                    timer: 2000,
                    showConfirmButton: false
                });
            }, 2000);
        }

        $(document).ready(function() {
            // DataTable initialization
            $('#alumniTable').DataTable({
                "pageLength": 25,
                "order": [
                    [1, "asc"]
                ],
                "columnDefs": [{
                        "orderable": false,
                        "targets": [14]
                    } // Actions column not sortable
                ],
                "searching": false, // Disable default search since we have custom search
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang cocok",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });

            // SweetAlert handling
            function getQueryParam(param) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

            const status = getQueryParam('status');
            const message = getQueryParam('message');

            if (status && message) {
                Swal.fire({
                    icon: status === 'success' ? 'success' : 'error',
                    title: status === 'success' ? 'Berhasil' : 'Gagal',
                    text: decodeURIComponent(message),
                    timer: 4000,
                    timerProgressBar: true,
                    willClose: () => {
                        const url = window.location.origin + window.location.pathname;
                        window.history.replaceState({}, document.title, url);
                    }
                });
            }
        });
    </script>
@endsection