<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Pengguna Lulusan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
            background-color: #fff;
            font-size: 14px;
        }

        main {
            flex: 1;
        }

        header {
            background-color: #fff;
            border-bottom: 1px solid #fff;
            padding: 20px;
            display: flex;
            align-items: center;
        }

        header img {
            height: 60px;
            margin-right: 15px;
        }

        header h3 {
            font-size: 22px;
            margin: 0;
            font-weight: 700;
        }

        header p {
            margin: 0;
            font-size: 14px;
        }

        .form-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        h2 {
            font-size: 18px;
            font-weight: 600;
            margin: 30px 0 15px;
        }

        .form-section {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: 600;
            font-size: 14px;
            margin-top: 10px;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #999;
            border-radius: 5px;
            font-size: 14px;
        }

        textarea {
            min-height: 100px;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row>div {
            flex: 1;
        }

        .rating-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 10px;
        }

        .rating-label {
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .rating-options {
            display: flex;
            gap: 10px;
            flex: 1;
            justify-content: center;
        }

        .rating-options input[type="radio"] {
            accent-color: #007649;
            transform: scale(1.2);
        }

        .rating-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 5px;
            /* Kurangi gap */
        }

        .rating-options {
            display: flex;
            gap: 0.1px;
            /* Kurangi gap antara input radio */
            flex: 1;
            justify-content: center;
        }

        .rating-label {
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            margin: 0;
            /* Menghilangkan margin untuk merapatkan dengan radio */
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        button {
            padding: 10px 25px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button[type="submit"] {
            background-color: #007649;
            color: white;
        }

        button.kembali {
            background-color: #ccc;
            color: black;
        }

        footer {
            text-align: center;
            background-color: #f4cf58;
            padding: 12px 0;
            font-size: 13px;
            font-weight: 600;
            color: #000;
            margin-top: 50px;
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

    <main>
        <form class="form-container" action="" method="POST">
            <h1>Survey</h1>

            <!-- Pengguna Lulusan -->
            <div class="form-section">
                <h2>Pengguna Lulusan</h2>
                <label for="nama_pl">Nama</label>
                <input type="text" id="nama_pl" name="nama_pl" required>

                <label for="instansi">Instansi</label>
                <input type="text" id="instansi" name="instansi" required>

                <label for="jabatan">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" required>

                <label for="email_pl">Email</label>
                <input type="email" id="email_pl" name="email_pl" required>
            </div>

            <!-- Alumni -->
            <div class="form-section">
                <h2>Alumni</h2>
                <label for="nama_alumni">Nama</label>
                <input type="text" id="nama_alumni" name="nama_alumni" required>

                <div class="form-row">
                    <div>
                        <label for="prodi">Program Studi</label>
                        <input type="text" id="prodi" name="prodi" required>
                    </div>
                    <div>
                        <label for="tgl_lulus">Tahun Lulus</label>
                        <input type="text" id="tgl_lulus" name="tgl_lulus" required>
                    </div>
                </div>
            </div>

            <!-- Penilaian -->
            <div class="form-section">
                <h2>Penilaian</h2>

                <div class="mb-3">
                    <label class="d-block">Kerjasama</label>
                    <div class="rating-group">
                        <span class="rating-label">Sangat Kurang</span>
                        <div class="rating-options">
                            <input type="radio" name="kerjasama" value="1">
                            <input type="radio" name="kerjasama" value="2">
                            <input type="radio" name="kerjasama" value="3">
                            <input type="radio" name="kerjasama" value="4">
                            <input type="radio" name="kerjasama" value="5">
                        </div>
                        <span class="rating-label">Sangat Baik</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="d-block">Keahlian bidang TI</label>
                    <div class="rating-group">
                        <span class="rating-label">Sangat Kurang</span>
                        <div class="rating-options">
                            <input type="radio" name="ti" value="1">
                            <input type="radio" name="ti" value="2">
                            <input type="radio" name="ti" value="3">
                            <input type="radio" name="ti" value="4">
                            <input type="radio" name="ti" value="5">
                        </div>
                        <span class="rating-label">Sangat Baik</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="d-block">Kemampuan bahasa asing</label>
                    <div class="rating-group">
                        <span class="rating-label">Sangat Kurang</span>
                        <div class="rating-options">
                            <input type="radio" name="kerjasama" value="1">
                            <input type="radio" name="kerjasama" value="2">
                            <input type="radio" name="kerjasama" value="3">
                            <input type="radio" name="kerjasama" value="4">
                            <input type="radio" name="kerjasama" value="5">
                        </div>
                        <span class="rating-label">Sangat Baik</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="d-block">Kemampuan Komunikasi</label>
                    <div class="rating-group">
                        <span class="rating-label">Sangat Kurang</span>
                        <div class="rating-options">
                            <input type="radio" name="kerjasama" value="1">
                            <input type="radio" name="kerjasama" value="2">
                            <input type="radio" name="kerjasama" value="3">
                            <input type="radio" name="kerjasama" value="4">
                            <input type="radio" name="kerjasama" value="5">
                        </div>
                        <span class="rating-label">Sangat Baik</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="d-block">Penegmbanagan diri</label>
                    <div class="rating-group">
                        <span class="rating-label">Sangat Kurang</span>
                        <div class="rating-options">
                            <input type="radio" name="kerjasama" value="1">
                            <input type="radio" name="kerjasama" value="2">
                            <input type="radio" name="kerjasama" value="3">
                            <input type="radio" name="kerjasama" value="4">
                            <input type="radio" name="kerjasama" value="5">
                        </div>
                        <span class="rating-label">Sangat Baik</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="d-block">Kepemimpinan</label>
                    <div class="rating-group">
                        <span class="rating-label">Sangat Kurang</span>
                        <div class="rating-options">
                            <input type="radio" name="kerjasama" value="1">
                            <input type="radio" name="kerjasama" value="2">
                            <input type="radio" name="kerjasama" value="3">
                            <input type="radio" name="kerjasama" value="4">
                            <input type="radio" name="kerjasama" value="5">
                        </div>
                        <span class="rating-label">Sangat Baik</span>
                    </div>
                </div>

            </div>

            <!-- Teks Tambahan -->
            <div class="mb-3">
                <label for="kompetensi_belum_terpenuhi">Kompetensi yang dibutuhkan tapi belum dapat dipenuhi</label>
                <textarea id="kompetensi_belum_terpenuhi" name="kompetensi_belum_terpenuhi" required></textarea>
            </div>

            <div class="mb-3">
                <label for="saran_kurikulum">Saran untuk kurikulum program studi</label>
                <textarea id="saran_kurikulum" name="saran_kurikulum" required></textarea>
            </div>

            <!-- Tombol -->
            <div class="button-group">
                <button type="button" class="kembali"
                    onclick="window.location.href='{{ route('form.opsi') }}'">Kembali</button>
                <button type="submit">Simpan</button>
            </div>
        </form>
    </main>

    <footer>
        © 2025 Politeknik Negeri Malang. All Rights Reserved.
    </footer>
</body>

</html>
