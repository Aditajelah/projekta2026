<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Komentar</title>
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

        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.08);
            padding: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 14px;
        }

        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 14px;
        }

        .search-input {
            width: 100%;
            max-width: 380px;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 14px;
        }

        .table-scroll {
            overflow-x: auto;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 860px;
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
        }

        th {
            color: #374151;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        td {
            font-size: 14px;
            color: #111827;
        }

        .comment-text {
            max-width: 420px;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .rating-badge {
            font-weight: 700;
            color: #b45309;
        }

        .muted {
            color: #6b7280;
        }

        .pagination {
            margin-top: 16px;
        }

        .empty-message {
            text-align: center;
            padding: 30px 12px;
            color: #6b7280;
        }

        .no-search-result {
            display: none;
            text-align: center;
            padding: 14px;
            color: #6b7280;
        }

        .actions {
            min-width: 180px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .btn {
            width: 100%;
            border: none;
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-danger {
            background: #dc2626;
            color: #fff;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-warning {
            background: #f59e0b;
            color: #111827;
        }

        .btn-warning:hover {
            background: #d97706;
            color: #fff;
        }

        .btn:disabled {
            background: #d1d5db;
            color: #6b7280;
            cursor: not-allowed;
        }

        .warning-count {
            font-size: 12px;
            color: #6b7280;
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
                <a href="{{ route('admin.comments.index') }}" class="active">Manage Komentar</a>
                <a href="{{ route('admin.users.index') }}">Manage Member</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </aside>

        <main class="content">
            <div class="header">
                <h1>Manage Komentar</h1>
                <div class="username">{{ Auth::user()->username }}</div>
            </div>

            <div class="card">
                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->has('warning'))
                    <div class="alert-error">{{ $errors->first('warning') }}</div>
                @endif

                @if($comments->count() > 0)
                    <input class="search-input" id="comment-search" type="text" placeholder="Cari komentar, member, atau nama tempat...">
                    <div class="table-scroll">
                        <table id="comments-table">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Tipe Tempat</th>
                                    <th>Nama Tempat</th>
                                    <th>Rating</th>
                                    <th>Komentar</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comments as $comment)
                                    @php
                                        $rateable = $comment->rateable;
                                        $placeName = $rateable?->name ?? '-';
                                        $type = class_basename($comment->rateable_type);
                                        $warningCount = (int) ($comment->user->warning_count ?? 0);
                                        $maxReached = $warningCount >= $maxWarningCount;
                                    @endphp
                                    <tr>
                                        <td>{{ $comment->user->username ?? 'Member tidak ditemukan' }}</td>
                                        <td>{{ $type }}</td>
                                        <td>{{ $placeName }}</td>
                                        <td>
                                            @if(!is_null($comment->rating))
                                                <span class="rating-badge">* {{ $comment->rating }}</span>
                                            @else
                                                <span class="muted">-</span>
                                            @endif
                                        </td>
                                        <td class="comment-text">{{ $comment->review }}</td>
                                        <td>{{ $comment->created_at?->format('d M Y H:i') }}</td>
                                        <td>
                                            <div class="actions">
                                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Yakin hapus komentar ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus Komentar</button>
                                                </form>

                                                @if($comment->user)
                                                    <form action="{{ route('admin.comments.warning', $comment) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning" {{ $maxReached ? 'disabled' : '' }}>
                                                            Kirim Peringatan
                                                        </button>
                                                    </form>
                                                    <div class="warning-count">Peringatan: {{ $warningCount }}/{{ $maxWarningCount }}</div>
                                                @else
                                                    <div class="warning-count">Peringatan: -</div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="no-search-result" id="no-comment-result">Data tidak ditemukan.</div>

                    <div class="pagination">
                        {{ $comments->links() }}
                    </div>
                @else
                    <div class="empty-message">Belum ada komentar dari member.</div>
                @endif
            </div>
        </main>
    </div>

    <script>
        var input = document.getElementById('comment-search');
        var table = document.getElementById('comments-table');
        var empty = document.getElementById('no-comment-result');

        if (input && table) {
            input.addEventListener('input', function () {
                var keyword = input.value.toLowerCase().trim();
                var rows = table.querySelectorAll('tbody tr');
                var visibleCount = 0;

                rows.forEach(function (row) {
                    var text = row.textContent.toLowerCase();
                    var matched = text.indexOf(keyword) !== -1;
                    row.style.display = matched ? '' : 'none';
                    if (matched) {
                        visibleCount++;
                    }
                });

                if (empty) {
                    empty.style.display = visibleCount === 0 ? 'block' : 'none';
                }
            });
        }
    </script>
</body>
</html>
