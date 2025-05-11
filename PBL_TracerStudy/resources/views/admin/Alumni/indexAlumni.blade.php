{{-- filepath: c:\laragon\www\PBL_TracerStudy\PBL_TracerStudy\resources\views\admin\Alumni\indexAlumni.blade.php --}}
@extends('layouts.template')

@section('title', 'Data Alumni')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Data Alumni</h4>
            <a href="{{ route('alumni.create') }}" class="btn btn-primary">Tambah Data</a>
        </div>
        {{-- filepath: c:\laragon\www\PBL_TracerStudy\PBL_TracerStudy\resources\views\admin\Alumni\indexAlumni.blade.php --}}
        {{-- filepath: c:\laragon\www\PBL_TracerStudy\PBL_TracerStudy\resources\views\admin\Alumni\indexAlumni.blade.php --}}
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
@endsection
