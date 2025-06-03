<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPwAdminController extends Controller
{

    public function showLinkRequestForm(Request $request, $token = null)
    {
        return view('auth.resetpw', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // Mengirim email reset password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker('admin')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // Menampilkan form untuk request reset password
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.resetpw', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // Menyimpan password baru
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $admin = \App\Models\Admin::where('email', $request->email)->first();

        if (!$admin) {
            return response()->json(['message' => 'Email tidak ditemukan'], 404);
        }

        // Update password tanpa cek token
        $admin->password = Hash::make($request->password);
        $admin->save(); 
        return view('auth.login');

    }

    public function viewresetpw()
    {
        return view('auth.resetpw');
    }

    // public function reset(Request $request){
    //     Admin::update([
    //         'email' => $request->email,
    //     ]);
    // }
}
