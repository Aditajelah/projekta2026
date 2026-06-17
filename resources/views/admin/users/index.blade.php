<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Member</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            color: #1f2937;
        }

        .layout {
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
            color: #fff;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .brand {
            font-size: 20px;
            font-weight: 700;
            padding: 8px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .menu a,
        .menu button {
            width: 100%;
            text-align: left;
            padding: 11px 12px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: #d1d5db;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .menu a:hover,
        .menu button:hover,
        .menu .active {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
        }

        .content {
            flex: 1;
            padding: 28px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            color: #111827;
        }

        .username {
            color: #6b7280;
            font-weight: 600;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1.35fr;
            gap: 18px;
            align-items: start;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.08);
            padding: 20px;
        }

        .card h2 {
            font-size: 18px;
            margin-bottom: 14px;
            color: #111827;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .form-grid {
            display: grid;
            gap: 12px;
        }

        .form-group {
            display: grid;
            gap: 6px;
        }

        label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            color: #111827;
            background: #fff;
        }

        textarea {
            resize: vertical;
            min-height: 92px;
        }

        .btn-primary {
            margin-top: 4px;
            border: none;
            border-radius: 8px;
            background: #111827;
            color: #fff;
            font-weight: 600;
            padding: 10px 14px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #000;
        }

        .table-scroll {
            overflow-x: auto;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 680px;
        }

        thead {
            background: #f9fafb;
        }

        th,
        td {
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
            font-size: 14px;
        }

        th {
            color: #374151;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-admin {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-user {
            background: #dcfce7;
            color: #166534;
        }

        .pagination {
            margin-top: 14px;
        }

        .actions {
            display: grid;
            gap: 8px;
            min-width: 160px;
        }

        .btn-reset {
            border: none;
            border-radius: 8px;
            background: #b45309;
            color: #fff;
            padding: 8px 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-reset:hover {
            background: #92400e;
        }

        .btn-status {
            border: none;
            border-radius: 8px;
            color: #fff;
            padding: 8px 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-deactivate {
            background: #dc2626;
        }

        .btn-deactivate:hover {
            background: #b91c1c;
        }

        .btn-activate {
            background: #166534;
        }

        .btn-activate:hover {
            background: #14532d;
        }

        .status-dot {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #374151;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            display: inline-block;
        }

        .dot-active {
            background: #16a34a;
        }

        .dot-inactive {
            background: #dc2626;
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(17, 24, 39, 0.45);
            z-index: 999;
            padding: 16px;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 14px 40px rgba(17, 24, 39, 0.28);
        }

        .modal-card h3 {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .modal-card p {
            margin-bottom: 14px;
            color: #6b7280;
            font-size: 13px;
        }

        .modal-actions {
            margin-top: 12px;
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .btn-cancel {
            border: 1px solid #d1d5db;
            background: #fff;
            color: #111827;
            border-radius: 8px;
            padding: 8px 12px;
            font-weight: 600;
            cursor: pointer;
        }

        .helper-text {
            margin-bottom: 16px;
            color: #6b7280;
            font-size: 13px;
        }

        .inactive-reason {
            margin-top: 6px;
            font-size: 12px;
            color: #7f1d1d;
            line-height: 1.4;
        }

        @media (max-width: 1100px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 980px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .content {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">Admin Panel</div>
            <div class="menu">
                <a href="{{ route('admin.dashboard') }}">Home</a>
                <a href="{{ route('admin.places.index') }}">Manage Tempat</a>
                <a href="{{ route('admin.comments.index') }}">Manage Komentar</a>
                <a href="{{ route('admin.users.index') }}" class="active">Manage Member</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </aside>

        <main class="content">
            <div class="header">
                <h1>Manage Member</h1>
                <div class="username">{{ Auth::user()->username }}</div>
            </div>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <p class="helper-text">Password lama pengguna tidak dapat dilihat. Admin hanya bisa reset password pengguna.</p>

            <div class="grid">
                <div class="card">
                    <h2>Tambah Member/Admin</h2>
                    <form action="{{ route('admin.users.store') }}" method="POST" class="form-grid">
                        @csrf
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" name="username" type="text" value="{{ old('username') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" name="role" required>
                                <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>Member</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" name="password" type="password" required>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required>
                        </div>

                        <button type="submit" class="btn-primary">Simpan Akun</button>
                    </form>
                </div>

                <div class="card">
                    <h2>Daftar Member</h2>
                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role === 'admin')
                                                <span class="badge badge-admin">Admin</span>
                                            @else
                                                <span class="badge badge-user">Member</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="status-dot"><span class="dot dot-active"></span>Aktif</span>
                                            @else
                                                <span class="status-dot"><span class="dot dot-inactive"></span>Nonaktif</span>
                                                @if(!empty($user->deactivation_reason_detail))
                                                    <div class="inactive-reason">{{ $user->deactivation_reason_detail }}</div>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at?->format('d M Y H:i') }}</td>
                                        <td>
                                            <div class="actions">
                                                <button
                                                    type="button"
                                                    class="btn-reset"
                                                    data-reset-user-id="{{ $user->id }}"
                                                    data-reset-username="{{ $user->username }}"
                                                    data-reset-url="{{ route('admin.users.reset-password', $user) }}"
                                                >
                                                    Reset Password
                                                </button>

                                                @if($user->is_active)
                                                    <button
                                                        type="button"
                                                        class="btn-status btn-deactivate"
                                                        data-deactivate-user-id="{{ $user->id }}"
                                                        data-deactivate-username="{{ $user->username }}"
                                                        data-deactivate-url="{{ route('admin.users.update-status', $user) }}"
                                                    >
                                                        Nonaktifkan
                                                    </button>
                                                @else
                                                    <form action="{{ route('admin.users.update-status', $user) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="is_active" value="1">
                                                        <button type="submit" class="btn-status btn-activate">Aktifkan</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Belum ada member.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="modal" id="reset-password-modal">
        <div class="modal-card">
            <h3>Reset Password Member</h3>
            <p id="reset-password-desc">Masukkan password baru untuk member.</p>

            <form id="reset-password-form" method="POST">
                @csrf
                <div class="form-group">
                    <label for="modal_password">Password Baru</label>
                    <input id="modal_password" type="password" name="password" required minlength="8">
                </div>

                <div class="form-group">
                    <label for="modal_password_confirmation">Konfirmasi Password Baru</label>
                    <input id="modal_password_confirmation" type="password" name="password_confirmation" required minlength="8">
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="close-reset-modal">Batal</button>
                    <button type="submit" class="btn-reset">Simpan Password</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="deactivate-member-modal">
        <div class="modal-card">
            <h3>Nonaktifkan Akun Member</h3>
            <p id="deactivate-member-desc">Pilih alasan dan isi penjelasan mengapa akun dinonaktifkan.</p>

            <form id="deactivate-member-form" method="POST">
                @csrf
                <input type="hidden" name="is_active" value="0">

                <div class="form-group">
                    <label for="deactivation_reason_code">Alasan Penonaktifan</label>
                    <select id="deactivation_reason_code" name="reason_code" required>
                        <option value="">-- Pilih alasan --</option>
                        @foreach($deactivationReasons as $reasonCode => $reasonLabel)
                            <option value="{{ $reasonCode }}">{{ $reasonLabel }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="deactivation_reason_detail">Penjelasan</label>
                    <textarea id="deactivation_reason_detail" name="reason_detail" required minlength="10" maxlength="1000" placeholder="Tuliskan detail alasan penonaktifan akun..."></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="close-deactivate-modal">Batal</button>
                    <button type="submit" class="btn-status btn-deactivate">Nonaktifkan Akun</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            var modal = document.getElementById('reset-password-modal');
            var closeBtn = document.getElementById('close-reset-modal');
            var resetForm = document.getElementById('reset-password-form');
            var resetDesc = document.getElementById('reset-password-desc');
            var openButtons = document.querySelectorAll('[data-reset-user-id]');
            var deactivateModal = document.getElementById('deactivate-member-modal');
            var closeDeactivateBtn = document.getElementById('close-deactivate-modal');
            var deactivateForm = document.getElementById('deactivate-member-form');
            var deactivateDesc = document.getElementById('deactivate-member-desc');
            var deactivateButtons = document.querySelectorAll('[data-deactivate-user-id]');

            function closeModal() {
                if (!modal || !resetForm) {
                    return;
                }

                modal.classList.remove('show');
                resetForm.reset();
            }

            function closeDeactivateModal() {
                if (!deactivateModal || !deactivateForm) {
                    return;
                }

                deactivateModal.classList.remove('show');
                deactivateForm.reset();
            }

            openButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    if (!modal || !resetForm || !resetDesc) {
                        return;
                    }

                    var userId = button.getAttribute('data-reset-user-id');
                    var username = button.getAttribute('data-reset-username') || 'member';
                    var resetUrl = button.getAttribute('data-reset-url') || '/admin/users/' + userId + '/reset-password';
                    resetForm.setAttribute('action', resetUrl);
                    resetDesc.textContent = 'Masukkan password baru untuk member ' + username + '.';
                    modal.classList.add('show');
                });
            });

            deactivateButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    if (!deactivateModal || !deactivateForm || !deactivateDesc) {
                        return;
                    }

                    var userId = button.getAttribute('data-deactivate-user-id');
                    var username = button.getAttribute('data-deactivate-username') || 'member';
                    var deactivateUrl = button.getAttribute('data-deactivate-url') || '/admin/users/' + userId + '/status';
                    deactivateForm.setAttribute('action', deactivateUrl);
                    deactivateDesc.textContent = 'Pilih alasan dan isi penjelasan penonaktifan untuk member ' + username + '.';
                    deactivateModal.classList.add('show');
                });
            });

            if (closeBtn) {
                closeBtn.addEventListener('click', closeModal);
            }

            if (modal) {
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeModal();
                    }
                });
            }

            if (closeDeactivateBtn) {
                closeDeactivateBtn.addEventListener('click', closeDeactivateModal);
            }

            if (deactivateModal) {
                deactivateModal.addEventListener('click', function (event) {
                    if (event.target === deactivateModal) {
                        closeDeactivateModal();
                    }
                });
            }
        })();
    </script>
</body>
</html>
