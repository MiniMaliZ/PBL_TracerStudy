{{-- filepath: c:\laragon\www\PBL_TracerStudy\PBL_TracerStudy\resources\views\admin\alumni\edit.blade.php --}}
@extends('layouts.template')

@section('title', 'Edit Alumni')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Edit Alumni</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('alumni.update', $alumni->nim) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_alumni">Nama Alumni</label>
                <input type="text" name="nama_alumni" id="nama_alumni" class="form-control" value="{{ $alumni->nama_alumni }}" required>
            </div>
            <div class="form-group">
                <label for="prodi">Prodi</label>
                <input type="text" name="prodi" id="prodi" class="form-control" value="{{ $alumni->prodi }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $alumni->email }}" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('alumni.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection