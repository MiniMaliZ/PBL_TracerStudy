{{-- filepath: c:\laragon\www\PBL_TracerStudy\PBL_TracerStudy\resources\views\admin\Admin\editAdmin.blade.php --}}
@extends('layouts.template')

@section('title', 'Edit Admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Edit Admin</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.update', $admin->id_admin) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ $admin->username }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="nama">Nama Admin</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ $admin->nama }}" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('adminForm').addEventListener('submit', function (e) {
        const passwordInput = document.getElementById('password');
        const password = passwordInput.value;

        // Hapus pesan error sebelumnya
        const errorElement = document.querySelector('.password-error');
        if (errorElement) {
            errorElement.remove();
        }

        // Validasi panjang password
        if (password.length > 0 && password.length < 6) {
            e.preventDefault(); // Cegah pengiriman form

            // Tampilkan pesan error
            const errorMessage = document.createElement('small');
            errorMessage.classList.add('text-danger', 'password-error');
            errorMessage.textContent = 'Password harus memiliki minimal 6 karakter.';
            passwordInput.parentNode.appendChild(errorMessage);

            // Fokuskan ke input password
            passwordInput.focus();
        }
    });
</script>
@endsection