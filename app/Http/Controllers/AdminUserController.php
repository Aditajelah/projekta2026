<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Notifications\AdminResetPasswordNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    // Daftar alasan baku saat admin menonaktifkan akun member.
    private const DEACTIVATION_REASONS = [
        'policy_violation' => 'Pelanggaran kebijakan platform',
        'spam_activity' => 'Aktivitas spam / penyalahgunaan fitur',
        'security_issue' => 'Keamanan akun perlu verifikasi',
        'identity_mismatch' => 'Data akun tidak sesuai verifikasi',
        'other' => 'Alasan lainnya',
    ];

    /**
     * Menampilkan daftar akun untuk manajemen user/admin oleh admin.
     */
    public function index()
    {
        $this->ensureAdmin();

        $users = User::latest()->paginate(20);
        $deactivationReasons = self::DEACTIVATION_REASONS;

        return view('admin.users.index', compact('users', 'deactivationReasons'));
    }

    /**
     * Membuat akun baru dari panel admin.
     */
    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'member'])],
        ]);

        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun baru berhasil ditambahkan.');
    }

    /**
     * Reset password akun target dan kirim notifikasi email.
     */
    public function resetPassword(Request $request, User $user)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        $user->notify(new AdminResetPasswordNotification());

        return redirect()->route('admin.users.index')->with('success', 'Password untuk member ' . $user->username . ' berhasil direset.');
    }

    /**
     * Mengaktifkan/menonaktifkan akun member beserta alasan jika dinonaktifkan.
     */
    public function updateStatus(Request $request, User $user)
    {
        $this->ensureAdmin();

        $before = $user->toArray();

        $validated = $request->validate([
            'is_active' => 'required|boolean',
            'reason_code' => ['nullable', 'string', Rule::in(array_keys(self::DEACTIVATION_REASONS))],
            'reason_detail' => 'nullable|string|min:10|max:1000',
        ]);

        $isActive = (bool) $validated['is_active'];

        if ((int) Auth::id() === (int) $user->id && !$isActive) {
            return redirect()->route('admin.users.index')->withErrors([
                'status' => 'Admin tidak dapat menonaktifkan akun sendiri.',
            ]);
        }

        if (!$isActive) {
            if (empty($validated['reason_code'])) {
                return redirect()->route('admin.users.index')->withErrors([
                    'status' => 'Pilih alasan penonaktifan akun terlebih dahulu.',
                ]);
            }

            if (empty($validated['reason_detail'])) {
                return redirect()->route('admin.users.index')->withErrors([
                    'status' => 'Isi penjelasan alasan penonaktifan akun.',
                ]);
            }
        }

        $payload = [
            'is_active' => $isActive,
            'deactivation_reason_code' => null,
            'deactivation_reason_detail' => null,
        ];

        if (!$isActive) {
            $payload['deactivation_reason_code'] = $validated['reason_code'];
            $payload['deactivation_reason_detail'] = trim($validated['reason_detail']);
        }

        $user->update($payload);
        $user->refresh();

        $this->writeAuditLog('update', 'member_status', $user->getKey(), $before, $user->toArray());

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.users.index')->with('success', 'Akun ' . $user->username . ' berhasil ' . $statusText . '.');
    }

    /**
     * Guard sederhana agar hanya admin yang bisa mengakses endpoint ini.
     */
    private function ensureAdmin(): void
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
    }

    /**
     * Menulis jejak perubahan status akun ke tabel audit log.
     */
    private function writeAuditLog(string $action, string $entityType, int $entityId, ?array $beforeData, ?array $afterData): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'admin_name' => Auth::user()?->username,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'before_data' => $beforeData,
            'after_data' => $afterData,
            'changed_at' => now(),
        ]);
    }
}
