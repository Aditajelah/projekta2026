<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Log Admin</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; margin: 0; }
        .container { max-width: 1300px; margin: 30px auto; padding: 0 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header a { text-decoration: none; background: #3498db; color: #fff; padding: 10px 14px; border-radius: 6px; }
        .card { background: #fff; border-radius: 10px; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08); padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #eee; padding: 10px; text-align: left; vertical-align: top; }
        th { background: #fafafa; color: #444; }
        .meta { font-size: 12px; color: #666; }
        pre { white-space: pre-wrap; word-break: break-word; background: #fafafa; padding: 8px; border-radius: 6px; font-size: 12px; max-height: 180px; overflow: auto; }
        .pill { display: inline-block; padding: 3px 8px; border-radius: 999px; font-size: 12px; font-weight: 600; }
        .create { background: #d4edda; color: #155724; }
        .update { background: #d1ecf1; color: #0c5460; }
        .delete { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Audit Log Perubahan Data</h1>
            <a href="{{ route('admin.dashboard') }}">Kembali ke Dashboard</a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Admin</th>
                        <th>Aksi</th>
                        <th>Entity</th>
                        <th>ID</th>
                        <th>Sebelum</th>
                        <th>Sesudah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>
                                {{ $log->changed_at?->format('d-m-Y H:i:s') }}
                                <div class="meta">{{ $log->created_at?->diffForHumans() }}</div>
                            </td>
                            <td>{{ $log->admin_name ?? ($log->user?->username ?? '-') }}</td>
                            <td><span class="pill {{ $log->action }}">{{ strtoupper($log->action) }}</span></td>
                            <td>{{ $log->entity_type }}</td>
                            <td>{{ $log->entity_id }}</td>
                            <td>
                                @if($log->before_data)
                                    <pre>{{ json_encode($log->before_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($log->after_data)
                                    <pre>{{ json_encode($log->after_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Belum ada log perubahan data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 14px;">{{ $logs->links() }}</div>
        </div>
    </div>
</body>
</html>
