<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User</title>
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
        select {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            color: #111827;
            background: #fff;
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
                <a href="{{ route('admin.users.index') }}" class="active">Manage User</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </aside>

        <main class="content">
            <div class="header">
                <h1>Manage User</h1>
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

            <div class="grid">
                <div class="card">
                    <h2>Tambah User/Admin</h2>
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
                                <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>User</option>
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
                    <h2>Daftar User</h2>
                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Dibuat</th>
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
                                                <span class="badge badge-user">User</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at?->format('d M Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Belum ada user.</td>
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
</body>
</html>
