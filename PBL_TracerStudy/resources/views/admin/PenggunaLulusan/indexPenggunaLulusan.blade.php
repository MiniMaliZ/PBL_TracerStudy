@extends('layouts.template')

@section('title', 'Pengguna Lulusan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Daftar Pengguna Lulusan</h4>
        <div>
            <a href="{{ route('penggunaLulusan.export') }}" class="btn btn-warning me-2">
                <i class="fas fa-file-excel"></i> Export Belum Survey
            </a>
            <a href="{{ route('penggunaLulusan.exportSudahIsiSurvey') }}" class="btn btn-success me-2">
                <i class="fas fa-file-excel"></i> Export Sudah Survey
            </a>
            <a href="{{ route('penggunaLulusan.create') }}" class="btn btn-primary">Tambah Data</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Atasan</th>
                    <th>Jabatan Atasan</th>
                    <th>Email Atasan</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penggunaLulusan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_atasan }}</td>
                    <td>{{ $item->jabatan_atasan }}</td>
                    <td>{{ $item->email_atasan }}</td>
                    <td>
                        <a href="{{ route('penggunaLulusan.edit', $item->id_pengguna_lulusan) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('penggunaLulusan.destroy', $item->id_pengguna_lulusan) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection