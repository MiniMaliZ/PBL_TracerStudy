<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Study - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(to bottom, #0d6e4e 50%, #f5f5f5 50%);
            height: 100vh;
            display: flex;
            justify-content: center;
            padding: 0 5rem; /* Padding kiri-kanan */
            margin-top: 2rem;
            padding-bottom: 2rem;
            overflow: hidden;
        }
        
        .left-panel {
            background-color: #0d6e4e;
            color: white;
            width: 100%;
            height: 45%;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            margin-left: -50px;  /* Geser logo ke kiri */

        }
        
        .left-panel h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
            margin-top: -40px;
        }
        
        .left-panel p {
            font-size: 1.2rem;
            line-height: 1.6;
            max-width: 80%;
            margin-top: -10px;
        }
        
        .illustration {
            position: relative;
            width: 100%;
            height: 50%;
            margin-top: 2rem;
        }
        
        .illustration img {
            width: 100%;
            max-width: 400px;
            height: auto;
        }
        
        .right-panel {
            width: 40%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        
        .login-container {
    background-color: white;
    border-radius: 10px;
    margin: 0 auto;  /* Tetap terpusat horizontal */
    padding: 4rem;   /* Padding besar untuk membuat container lebih lebar */
    width: 90%;      /* Lebar relatif untuk responsif */
    max-width: 600px; /* Lebar maksimum yang lebih besar */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    box-sizing: border-box;
}

@media (max-width: 768px) {
    .login-container {
        padding: 2rem;  /* Padding lebih kecil untuk mobile */
        width: 85%;     /* Lebar lebih besar di mobile */
        margin: 2rem auto; /* Tetap terpusat */
    }
}

        
        .welcome-text {
            margin-bottom: 1.5rem;
        }
        
        .welcome-text h2 {
            font-size: 1.2rem;
            color: #0d6e4e;
            font-weight: 500;
        }
        
        .welcome-text h1 {
            font-size: 2rem;
            color: #333;
            margin-top: 0.5rem;
        }
        
        .input-group {
            margin-bottom: 1.5rem;
        }
        
        .input-group label {
            display: block;
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .input-group input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .input-group input:focus {
            outline: none;
            border-color: #0d6e4e;
        }
        
        .login-btn {
            background-color: #0d6e4e;
            color: white;
            border: none;
            padding: 0.8rem;
            width: 100%;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .login-btn:hover {
            background-color: #085d41;
        }
        
        .signup-link {
            text-align: right;
            margin-top: 1rem;
            font-size: 0.9rem;
        }
        
        .signup-link a {
            color: #0d6e4e;
            text-decoration: none;
        }
        
        .signup-link a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            body {
                flex-direction: column;
                overflow-y: auto;
            }
            
            .left-panel {
                width: 100%;
                height: 30vh;
                margin-top: -20px;
                padding: 2.5rem;
            }
            
            .left-panel p {
                max-width: 100%;
                font-size: 2rem;
            }
            
            .illustration {
                display: none;
            }
            
            .right-panel {
                width: 100%;
                height: 70vh;
            }
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<body>
    <div class="left-panel">
        <div class="logo">
            <img src="logo-tracer.png" alt="Logo Tracer Study" width="250">
        </div>
        <h1>Login to<br>Sistem Tracer Study</h1>
        <p>Tracer Study adalah survei yang dilakukan oleh institusi pendidikan kepada alumni untuk melacak jejak karier dan penilaian terhadap pendidikan yang telah diterima.</p>
        <div class="illustration">
            <img src="/api/placeholder/400/320" alt="Tracer Study Illustration">
        </div>
    </div>
    
    <div class="right-panel">
        <div class="login-container">
            <div class="welcome-text">
                <h2>Welcome to Tracer Study</h2>
                <h1>Login</h1>
            </div>
            
            <form id="loginForm" method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="input-group">
                    <label for="username">Enter your username</label>
                    <input type="text" id="username" name="username" placeholder="Username">
                    <small id="error-username" class="error-text text-danger"></small>
                </div>
                
                <div class="input-group">
                    <label for="password">Enter your Password</label>
                    <input type="password" id="password" name="password" placeholder="Password">
                    <small id="error-password" class="error-text text-danger"></small>
                </div>
                
                <button type="submit" class="login-btn">Login</button>
            </form>
        
            <!-- jQuery dan SweetAlert2 -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
            <script>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        
                $(document).ready(function () {
                    $('#loginForm').on('submit', function (e) {
                        e.preventDefault();
        
                        const form = this;
                        const formData = $(form).serialize();
        
                        // Clear previous errors
                        $('.error-text').text('');
        
                        $.ajax({
                            url: $(form).attr('action'),
                            method: $(form).attr('method'),
                            data: formData,
                            success: function (response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Login Berhasil',
                                        text: response.message
                                    }).then(() => {
                                        window.location.href = response.redirect;
                                    });
                                } else {
                                    $.each(response.msgField, function (prefix, val) {
                                        $('#error-' + prefix).text(val[0]);
                                    });
        
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Login Gagal',
                                        text: response.message
                                    });
                                }
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: xhr.status === 419 ? 'Session expired (CSRF token tidak valid)' : 'Login gagal, cek kembali data Anda.'
                                });
                            }
                        });
                    });
                });
            </script>
</body>
</html>