<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tracer Study</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 20px;
            display: flex;
            align-items: center;
        }

        header img {
            height: 60px;
            margin-right: 20px;
        }

        footer {
            text-align: center;
            background-color: #f4cf58;
            padding: 10px 0;
            font-size: 12px;
            font-weight: bold;
            color: #000;
            margin-top: 50px;
        }

        .form-section {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 4px 4px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .form-section h2 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <header class="container d-flex align-items-center py-2 border-bottom">
        <img src="{{ asset('landingpageimg/Logo_Polinema 1.png') }}"> 
        <div style="line-height: 1.2;">
            <h3 class="mb-0" style="font-size: 20px;">TRACER STUDY</h3>
            <p class="mb-0" style="font-size: 14px;">Politeknik Negeri Malang</p>
        </div>
    </header>
    
    <main class="container my-5">
        <form action="" method="POST">
            <h1 class="mb-4">Formulir</h1>

            <!-- Detail Pribadi -->
            <div class="form-section">
                <h2>Detail Pribadi</h2>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="NIM" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nama_alumni" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama_alumni" name="nama_alumni" placeholder="Nama" required>
                    </div>
                    <div class="col-md-6">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <input type="text" class="form-control" id="prodi" name="prodi" placeholder="Program Studi" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tgl_lulus" class="form-label">Tanggal Lulus</label>
                        <input type="date" class="form-control" id="tgl_lulus" name="tgl_lulus" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="no_hp" class="form-label">No. HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="No HP" required>
                    </div>
                </div>
            </div>

            <!-- Detail Profesi -->
            <div class="form-section">
                <h2>Detail Profesi</h2>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_instansi" class="form-label">Nama Instansi</label>
                        <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" required>
                    </div>
                    <div class="col-md-6">
                        <label for="jenis_instansi" class="form-label">Jenis Instansi</label>
                        <input type="text" class="form-control" id="jenis_instansi" name="jenis_instansi" required>
                    </div>
                    <div class="col-md-6">
                        <label for="skala_instansi" class="form-label">Skala Instansi</label>
                        <select class="form-select" id="skala_instansi" name="skala_instansi" required>
                            <option value="" disabled selected>Pilih...</option>
                            <option value="Nasional">Nasional</option>
                            <option value="Wirausaha">Wirausaha</option>
                            <option value="Multinasional">Multinasional</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_kerja_pertama" class="form-label">Tanggal Pertama Bekerja</label>
                        <input type="text" class="form-control" id="tanggal_kerja_pertama" name="tanggal_kerja_pertama" placeholder="DD/MM/YYYY" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lokasi_instansi" class="form-label">Lokasi Instansi</label>
                        <input type="text" class="form-control" id="lokasi_instansi" name="lokasi_instansi" required>
                    </div>
                    <div class="col-md-6">
                        <label for="kategori_profesi" class="form-label">Kategori Profesi</label>
                        <select class="form-select" id="kategori_profesi" name="kategori_profesi" required>
                            <option value="" disabled selected>Pilih...</option>
                            <option value="infokom">Infokom</option>
                            <option value="non infokom">Non Infokom</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="profesi" class="form-label">Profesi</label>
                        <input type="text" class="form-control" id="profesi" name="profesi" required>
                    </div>
                </div>
            </div>

            <!-- Detail Pengguna Lulusan -->
            <div class="form-section">
                <h2>Detail Pengguna Lulusan (Supervisor)</h2>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_pl" class="form-label">Nama Atasan</label>
                        <input type="text" class="form-control" id="nama_pl" name="nama_pl" required>
                    </div>
                    <div class="col-md-6">
                        <label for="jabatan" class="form-label">Jabatan Atasan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email_atasan" class="form-label">Email Atasan</label>
                        <input type="text" class="form-control" id="email_atasan" name="email_atasan" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nohp_atasan" class="form-label">No HP Atasan</label>
                        <input type="text" class="form-control" id="nohp_atasan" name="nohp_atasan" required>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="kembali" class="btn btn-secondary">Kembali</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </main>

    <footer>
        &copy; 2025 Politeknik Negeri Malang. All Rights Reserved.
    </footer>

</body>

</html>
