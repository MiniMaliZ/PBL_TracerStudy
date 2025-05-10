{{-- filepath: c:\laragon\www\PBL_TracerStudy\PBL_TracerStudy\resources\views\admin\alumni\create.blade.php --}}
@extends('layouts.template')

@section('title', 'Tambah Alumni')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Tambah Alumni</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('alumni.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" name="nim" id="nim" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="nama_alumni">Nama Alumni</label>
                <input type="text" name="nama_alumni" id="nama_alumni" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="prodi">Prodi</label>
                <input type="text" name="prodi" id="prodi" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('alumni.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection