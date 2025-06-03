<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tracer Study - Login</title>
  <meta name="description" content="Login to Tracer Study system"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            emerald: {
              700: '#13754C',
              800: '#084D30',
            },
            cyan: {
              400: '#22d3ee',
            },
            blue: {
              500: '#3b82f6',
              600: '#2563eb',
              700: '#1d4ed8',
            },
          },
        },
      },
    };
  </script>

  <!-- jQuery, Validation, SweetAlert2 -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- EmailJS -->
  <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
  <script>
    (function () {
      emailjs.init({
        publicKey: "m8m2s9y-LvQU7uahC",
      });
    })();
  </script>

  <style>
    @keyframes slowZoom {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }
    .animated-bg {
      animation: slowZoom 20s infinite ease-in-out;
    }

    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0px); }
    }
    .float-animation {
      animation: float 6s ease-in-out infinite;
    }
  </style>
</head>

<body class="bg-emerald-800 relative overflow-hidden min-h-screen flex items-center justify-center">

  <!-- Background -->
  <div class="absolute inset-0 z-0">
    <img src="{{ asset('images/campus-background.jpg') }}" alt="Campus Background" class="object-cover w-full h-full opacity-25 animated-bg" />
  </div>

  <!-- Main Container -->
  <div class="container mx-auto px-5 z-10">
    <div class="flex flex-col md:flex-row items-center justify-center max-w-7xl mx-auto">
      
      <!-- Left Side -->
      <div class="text-center text-white w-full md:w-1/2 max-w-xl mx-auto md:pr-12">
        <div class="flex justify-center mb-4">
          <div class="logo float-animation">
            <img src="{{ asset('logo-tracer.png') }}" alt="Logo Tracer Study" width="180" height="180">
          </div>
        </div>
        <h1 class="text-4xl font-bold mt-1">Login to</h1>
        <h2 class="text-4xl font-bold mb-6">Sistem Tracer Study</h2>
        <h3 class="text-2xl font-semibold mb-4">Welcome back, Admin!</h3>
        <p class="text-lg px-4">
          Tracer Study adalah survei yang dilakukan oleh institusi pendidikan kepada alumni untuk melacak jejak karier dan penilaian terhadap pendidikan yang telah diterima.
        </p>
      </div>

      <!-- Right Side Form -->
      <div class="bg-white/95 rounded-lg p-10 w-full max-w-xl shadow-xl mt-10 md:mt-0 md:ml-24">
        <!-- Login Form -->
        <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-6">
          @csrf
          <div>
            <p class="text-xl text-emerald-800 font-medium">Welcome to <span class="font-semibold text-emerald-700">Tracer Study</span></p>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Login</h2>
            <div id="login-error" class="text-red-600 text-sm hidden"></div>
          </div>

          <div>
            <label for="username" class="block text-base font-medium text-gray-700">Username</label>
            <input id="username" name="username" type="text" required placeholder="Username"
              class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500">
            @error('username')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
          </div>

          <div>
            <label for="password" class="block text-base font-medium text-gray-700">Password</label>
            <input id="password" name="password" type="password" required placeholder="Password"
              class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500">
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
          </div>

          <div class="flex items-center">
            <input id="remember_me" name="remember" type="checkbox" class="h-5 w-5 text-emerald-600 rounded border-gray-300">
            <label for="remember_me" class="ml-2 text-base text-gray-700">Remember me</label>
          </div>

          <button type="submit"
            class="w-full py-3 px-4 bg-emerald-700 hover:bg-emerald-800 text-white text-lg font-semibold rounded-md shadow-sm">
            Login
          </button>
        </form>

        <!-- Forgot Password -->
        <form id="forgot-password-form" method="POST" action="{{ route('admin.password.email') }}" class="mt-12 space-y-4">
          @csrf
          <h2 class="text-2xl font-bold text-gray-900 text-center">Forgot Password</h2>
          <p class="text-gray-700 text-center">Enter your email to receive a password reset link.</p>

          <div>
            <label for="email_reset" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input id="email_reset" name="email" type="email" required placeholder="Enter your email"
              class="w-full mt-1 px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
          </div>

          <button type="submit"
            class="w-full bg-emerald-700 text-white py-3 px-4 rounded-md hover:bg-emerald-800 font-semibold">
            Send Reset Link
          </button>

          <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Back to Login</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- AJAX Script -->
  <script>
    $.ajaxSetup({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // LOGIN
    $("#login-form").validate({
      rules: {
        username: { required: true, minlength: 4 },
        password: { required: true, minlength: 5 }
      },
      submitHandler: function (form) {
        Swal.fire({
          title: 'Logging in...',
          text: 'Please wait',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
        });

        $.ajax({
          url: form.action,
          method: form.method,
          data: $(form).serialize(),
          success: function (res) {
            if (res.status) {
              Swal.fire({
                icon: 'success',
                title: 'Login Berhasil!',
                text: res.message,
                timer: 2000,
                showConfirmButton: false
              }).then(() => {
                window.location.href = res.redirect;
              });
            } else {
              Swal.fire('Login Gagal!', res.message, 'error');
            }
          },
          error: () => {
            Swal.fire('Login Gagal!', 'Server error. Silakan coba lagi.', 'error');
          }
        });
      }
    });

    // FORGOT PASSWORD
    $("#forgot-password-form").validate({
      rules: {
        email: { required: true, email: true }
      }, 
      submitHandler: function (form) {
        const email = $('#email_reset').val();

        Swal.fire({
          title: 'Mengirim...',
          text: 'Harap tunggu sebentar',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
        });

        $.ajax({
          url: form.action,
          method: form.method,
          data: $(form).serialize(),
          success: function (res) {
            const redirectUrl = res.redirect;

            emailjs.send("service_fc2jmcj", "template_2d9ekzk", {
              to_email: email,
            }).then(() => {
              Swal.fire('Berhasil', 'Link telah dikirim ke email.', 'success').then(() => {
                if (redirectUrl) window.location.href = redirectUrl;
              });
            }).catch(() => {
              Swal.fire('Gagal', 'Link gagal dikirim. Form tetap disimpan.', 'error');
            });
          },
          error: () => {
            Swal.fire('Gagal', 'Terjadi kesalahan saat mengirim permintaan.', 'error');
          }
        });
      }
    });
  </script>
</body>
</html>