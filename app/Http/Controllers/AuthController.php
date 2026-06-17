<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Peta kode alasan nonaktif agar bisa ditampilkan sebagai pesan ramah user.
    private const DEACTIVATION_REASONS = [
        'policy_violation' => 'Pelanggaran kebijakan platform',
        'spam_activity' => 'Aktivitas spam / penyalahgunaan fitur',
        'security_issue' => 'Keamanan akun perlu verifikasi',
        'identity_mismatch' => 'Data akun tidak sesuai verifikasi',
        'other' => 'Alasan lainnya',
    ];

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member', // default role
        ]);

        auth()->login($user);

        return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang ' . $user->username);
    }

    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Memproses login termasuk pengecekan status aktif akun.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if ($user && !$user->is_active) {
            $message = 'Akun Anda sedang dinonaktifkan oleh admin.';

            if (!empty($user->deactivation_reason_code) && isset(self::DEACTIVATION_REASONS[$user->deactivation_reason_code])) {
                $message .= ' Alasan: ' . self::DEACTIVATION_REASONS[$user->deactivation_reason_code] . '.';
            }

            if (!empty($user->deactivation_reason_detail)) {
                $message .= ' Penjelasan: ' . $user->deactivation_reason_detail;
            }

            return back()
                ->withErrors(['email' => $message])
                ->with('inactive_account', true)
                ->withInput();
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'is_active' => true,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    /**
     * Mengakhiri sesi user dengan invalidasi session/token.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout berhasil!');
    }
}
