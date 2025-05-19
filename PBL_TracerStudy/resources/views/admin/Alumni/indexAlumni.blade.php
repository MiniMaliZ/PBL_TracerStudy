@extends('layouts.template')

@section('title', 'Data Alumni')

@section('content')
    <div class="card">
        {{-- Notifikasi Sukses atau Error --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Data Alumni</h4>
            <div>
                <a href="{{ route('alumni.create') }}" class="btn btn-primary">Tambah Data</a>
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalImport">Import Alumni</button>
                {{-- <a href="{{ route('alumni.export') }}" class="btn btn-outline-success">Export Excel</a> --}}
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Alumni</th>
                            <th>Prodi</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Tahun Masuk</th>
                            <th>Tanggal Lulus</th>
                            <th>Tanggal Kerja <br>Pertama</th>
                            <th>Tanggal Mulai <br>Instansi</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alumni as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nim }}</td>
                                <td>{{ $item->nama_alumni }}</td>
                                <td>{{ $item->prodi }}</td>
                                <td>{{ $item->no_hp }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->tahun_masuk }}</td>
                                <td>{{ $item->tgl_lulus }}</td>
                                <td>{{ $item->tanggal_kerja_pertama }}</td>
                                <td>{{ $item->tanggal_mulai_instansi }}</td>
                                <td>
                                    <a href="{{ route('alumni.edit', $item->nim) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('alumni.destroy', $item->nim) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Include Modal Import --}}
    @include('admin.Alumni.import') {{-- Buat file modalImport.blade.php jika belum --}}

    <script>
        $(document).ready(function () {
            // Function to get query parameters
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
                        // Clean URL by removing query params without reloading
                        const url = window.location.origin + window.location.pathname;
                        window.history.replaceState({}, document.title, url);
                    }
                });
            }
        });
    </script>
@endsection