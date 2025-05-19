<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Study - Login</title>
    <meta name="description" content="Login to Tracer Study system">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        }
    </script>
    <style>
        /* Background Animation */
        @keyframes slowZoom {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        .animated-bg {
            animation: slowZoom 20s infinite ease-in-out;
        }

        /* Optional: Gentle floating effect for the content */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-emerald-800 relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img
                src="{{ asset('images/campus-background.jpg') }}"
                alt="Campus Background"
                class="object-cover w-full h-full opacity-25 animated-bg"
            >
        </div>

        <div class="container mx-auto px-5 z-10">
            <div class="flex flex-col md:flex-row items-center md-max justify-center md:justify-between max-w-10xl mx-auto">
                <div class="text-center text-white w-full md:w-1/2 max-w-xl mx-auto pr-0 md:pr-12">
                    <div class="flex justify-center mb-4">
                        <div class="logo float-animation">
                        <div class="logo">
                            <img src="{{ asset('logo-tracer.png') }}" alt="Logo Tracer Study" width="180" height="180">
                        </div>
                        </div>
                    </div>
                    <h1 class="text-4xl font-bold mt-1">Login to</h1>
                    <h2 class="text-4xl font-bold mb-6">Sistem Tracer Study</h2>

                    <h3 class="text-2xl font-semibold mb-4">Welcome back, Admin!</h3>
                    <p class="text-lg md:text-xl mx-auto px-4">
                        Tracer Study adalah survei yang dilakukan oleh institusi pendidikan kepada alumni untuk melacak jejak karier dan penilaian terhadap pendidikan yang telah diterima.
                    </p>
                </div>

                <div class="bg-white/95 rounded-lg p-10 w-full max-w-xl h-auto min-h-[480px] flex flex-col shadow-xl mt-10 md:mt-12 md:ml-24">
                    <div class="mb-8">
                        <p class="text-xl text-emerald-800 font-medium">
                            Welcome to <span class="text-xl text-emerald-700 font-semibold">Tracer Study</span>
                        </p>
                        <h2 class="text-3xl font-bold text-gray-900">Login</h2>
                        <div id="login-error" class="text-red-600 mt-2 text-sm hidden"></div>
                    </div>

                    <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-8 flex-grow flex flex-col">
                        @csrf

                        <div class="space-y-2">
                            <label for="username" class="block text-base font-medium text-gray-700">
                                Enter your username
                            </label>
                            <input
                                id="username"
                                name="username"
                                type="text"
                                placeholder="Username"
                                class="w-full px-4 py-4 border border-gray-300 rounded-md shadow-sm text-lg focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                                required
                                autofocus
                            >
                            @error('username')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="block text-base font-medium text-gray-700">
                                Enter your Password
                            </label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="Password"
                                class="w-full px-4 py-4 border border-gray-300 rounded-md shadow-sm text-lg focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                                required
                            >
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input
                                id="remember_me"
                                name="remember"
                                type="checkbox"
                                class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                            >
                            <label for="remember_me" class="ml-2 block text-base text-gray-700">
                                Remember me
                            </label>
                        </div>

                        <div class="mt-auto">
                            <button
                                type="submit"
                                class="w-full flex justify-center py-4 px-4 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-emerald-700 hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                            >
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(document).ready(function() {
            $("#login-form").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                    },
                    password: {
                        required: true,
                        minlength: 5,
                        maxlength: 20
                    }
                },
                submitHandler: function(form) {
                    // Show loading state
                    Swal.fire({
                        title: 'Logging in...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                // Success popup
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Login Berhasil!',
                                    text: response.message,
                                    confirmButtonColor: '#13754C',
                                    timer: 2000,
                                    timerProgressBar: true
                                }).then(() => {
                                    window.location = response.redirect;
                                });
                            } else {
                                // Error popup
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Login Gagal!',
                                    text: response.message,
                                    confirmButtonColor: '#13754C'
                                });
                            }
                        },
                        error: function(xhr) {
                            // Server error popup
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Gagal!',
                                text: 'Terjadi kesalahan saat menghubungi server.',
                                confirmButtonColor: '#13754C'
                            });
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('text-red-500 text-sm');
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass('border-red-500');
                },
                unhighlight: function(element) {
                    $(element).removeClass('border-red-500');
                }
            });
        });
    </script>
</body>
</html>