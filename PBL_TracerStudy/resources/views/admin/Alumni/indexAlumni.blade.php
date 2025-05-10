{{-- filepath: c:\laragon\www\PBL_TracerStudy\PBL_TracerStudy\resources\views\admin\alumni\index.blade.php --}}
@extends('layouts.template')

@section('title', 'Data Alumni')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Data Alumni</h4>
        <a href="{{ route('alumni.create') }}" class="btn btn-primary">Tambah Data</a>
    </div>
    <div class="card-body">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama Alumni</th>
                    <th>Prodi</th>
                    <th>Email</th>
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
                    <td>{{ $item->email }}</td>
                    <td>
                        <a href="{{ route('alumni.edit', $item->nim) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('alumni.destroy', $item->nim) }}" method="POST" style="display:inline;">
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
@endsection