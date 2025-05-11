{{-- filepath: c:\laragon\www\PBL_TracerStudy\PBL_TracerStudy\resources\views\admin\Alumni\createAlumni.blade.php --}}
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
            {{-- Data Alumni --}}
            <h5 class="mb-3">Detail Pribadi</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" name="nim" id="nim" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_alumni">Nama</label>
                        <input type="text" name="nama_alumni" id="nama_alumni" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="prodi">Program Studi</label>
                        <input type="text" name="prodi" id="prodi" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tgl_lulus">Tanggal Lulus</label>
                        <input type="date" name="tgl_lulus" id="tgl_lulus" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="no_hp">No. HP</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control">
                    </div>
                </div>
            </div>

            <h5 class="mt-4 mb-3">Detail Pekerjaan</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_kerja_pertama">Tanggal Kerja Pertama</label>
                        <input type="date" name="tanggal_kerja_pertama" id="tanggal_kerja_pertama" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_mulai_instansi">Tanggal Mulai Instansi</label>
                        <input type="date" name="tanggal_mulai_instansi" id="tanggal_mulai_instansi" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kategori_profesi">Kategori Profesi</label>
                        <select name="kategori_profesi" id="kategori_profesi" class="form-control" required>
                            <option value="Infokom">Infokom</option>
                            <option value="Non Infokom">Non Infokom</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="profesi">Profesi</label>
                        <input type="text" name="profesi" id="profesi" class="form-control">
                    </div>
                </div>
            </div>

            <h5 class="mt-4 mb-3">Detail Pengguna Lulusan</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_atasan">Nama Atasan</label>
                        <input type="text" name="nama_atasan" id="nama_atasan" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jabatan_atasan">Jabatan Atasan</label>
                        <input type="text" name="jabatan_atasan" id="jabatan_atasan" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email_atasan">Email Atasan</label>
                        <input type="email" name="email_atasan" id="email_atasan" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_instansi">Nama Instansi</label>
                        <input type="text" name="nama_instansi" id="nama_instansi" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jenis_instansi">Jenis Instansi</label>
                        <select name="jenis_instansi" id="jenis_instansi" class="form-control">
                            <option value="Pendidikan Tinggi">Pendidikan Tinggi</option>
                            <option value="Instansi Pemerintah">Instansi Pemerintah</option>
                            <option value="BUMN">BUMN</option>
                            <option value="Perusahaan Swasta">Perusahaan Swasta</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="skala_instansi">Skala Instansi</label>
                        <select name="skala_instansi" id="skala_instansi" class="form-control">
                            <option value="Local">Local</option>
                            <option value="National">National</option>
                            <option value="International">International</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lokasi_instansi">Lokasi Instansi</label>
                        <input type="text" name="lokasi_instansi" id="lokasi_instansi" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="no_hp_instansi">No HP Instansi</label>
                        <input type="text" name="no_hp_instansi" id="no_hp_instansi" class="form-control">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-3">Simpan</button>
            <a href="{{ route('alumni.index') }}" class="btn btn-secondary mt-3">Batal</a>
        </form>
    </div>
</div>
@endsection