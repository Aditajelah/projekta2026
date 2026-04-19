<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tempat</title>
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

        .top-info {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 12px;
            color: #6b7280;
            font-weight: 600;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .admin-header h1 {
            color: #333;
            font-size: 28px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e74c3c;
        }

        .admin-title {
            color: #e74c3c;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #e74c3c;
        }

        .stat-card h3 {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .stat-card .number {
            font-size: 32px;
            font-weight: bold;
            color: #e74c3c;
        }

        .data-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .data-section h2 {
            color: #333;
            font-size: 20px;
        }

        .btn-add {
            background: #27ae60;
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-add:hover {
            background: #1f8d4e;
        }

        .search-input {
            width: 100%;
            max-width: 340px;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 14px;
        }

        .table-scroll {
            max-height: 390px;
            overflow-y: auto;
            border: 1px solid #ececec;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #f9f9f9;
        }

        table th {
            padding: 15px;
            text-align: left;
            color: #666;
            font-weight: 600;
            border-bottom: 1px solid #e0e0e0;
        }

        table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        table tbody tr:hover {
            background: #f5f5f5;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .price {
            color: #27ae60;
            font-weight: 600;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-edit {
            background: #3498db;
            color: white;
        }

        .btn-edit:hover {
            background: #2980b9;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .empty-message {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }

        .no-search-result {
            display: none;
            text-align: center;
            padding: 15px;
            color: #999;
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
                <a href="{{ route('admin.places.index') }}" class="active">Manage Tempat</a>
                <a href="{{ route('admin.comments.index') }}">Manage Komentar</a>
                <a href="{{ route('admin.users.index') }}">Manage User</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </aside>

        <main class="content">
        <div class="top-info">{{ Auth::user()->username }}</div>
        <div class="container">
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="admin-header">
            <div>
                <span class="admin-title">Administrator</span>
                <h1>Manage Tempat</h1>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Destinasi</h3>
                <div class="number">{{ $destinationCount }}</div>
            </div>
            <div class="stat-card">
                <h3>Total Kuliner</h3>
                <div class="number">{{ $culinaryCount }}</div>
            </div>
            <div class="stat-card">
                <h3>Total Penginapan</h3>
                <div class="number">{{ $stayCount }}</div>
            </div>
        </div>

        <div class="data-section" id="manage-tempat">
            <div class="section-header">
                <h2>Destinasi Wisata Terbaru</h2>
                <a href="{{ route('admin.destinations.create') }}" class="btn-add">+ Tambah Destinasi</a>
            </div>
            @if($destinations->count() > 0)
                <input class="search-input" type="text" placeholder="Cari destinasi..." data-search-target="destinations-table">
                <div class="table-scroll">
                    <table id="destinations-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Harga</th>
                                <th>Rating</th>
                                <th>Status Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($destinations as $destination)
                                <tr>
                                    <td><strong>{{ $destination->name }}</strong></td>
                                    <td>{{ $destination->location }}</td>
                                    <td class="price">{{ (float) $destination->price <= 0 ? 'Gratis' : 'Rp ' . number_format($destination->price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($destination->user_rating_avg)
                                            ⭐ {{ number_format($destination->user_rating_avg, 2) }} ({{ $destination->ratings_count }})
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $destination->status_lokasi === 'hidden gem' ? 'status-active' : 'status-inactive' }}">
                                            {{ $destination->status_lokasi === 'hidden gem' ? 'Hidden Gem' : 'Terkenal' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('admin.destinations.show', $destination) }}" class="btn-small btn-edit">Detail</a>
                                            <a href="{{ route('admin.destinations.edit', $destination) }}" class="btn-small btn-edit">Edit</a>
                                            <form action="{{ route('admin.destinations.destroy', $destination) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-small btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="no-search-result" data-empty-target="destinations-table">Data tidak ditemukan.</div>
            @else
                <div class="empty-message">
                    <p>Belum ada data destinasi</p>
                </div>
            @endif
        </div>

        <div class="data-section">
            <div class="section-header">
                <h2>Rekomendasi Kuliner Terbaru</h2>
                <a href="{{ route('admin.culinaries.create') }}" class="btn-add">+ Tambah Kuliner</a>
            </div>
            @if($culinary->count() > 0)
                <input class="search-input" type="text" placeholder="Cari kuliner..." data-search-target="culinary-table">
                <div class="table-scroll">
                    <table id="culinary-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Harga</th>
                                <th>Rating</th>
                                <th>Status Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($culinary as $item)
                                <tr>
                                    <td><strong>{{ $item->name }}</strong></td>
                                    <td>{{ $item->location }}</td>
                                    <td class="price">{{ (float) $item->price <= 0 ? 'Gratis' : 'Rp ' . number_format($item->price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($item->user_rating_avg)
                                            ⭐ {{ number_format($item->user_rating_avg, 2) }} ({{ $item->ratings_count }})
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $item->status_lokasi === 'hidden gem' ? 'status-active' : 'status-inactive' }}">
                                            {{ $item->status_lokasi === 'hidden gem' ? 'Hidden Gem' : 'Terkenal' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('admin.culinaries.show', $item) }}" class="btn-small btn-edit">Detail</a>
                                            <a href="{{ route('admin.culinaries.edit', $item) }}" class="btn-small btn-edit">Edit</a>
                                            <form action="{{ route('admin.culinaries.destroy', $item) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-small btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="no-search-result" data-empty-target="culinary-table">Data tidak ditemukan.</div>
            @else
                <div class="empty-message">
                    <p>Belum ada data kuliner</p>
                </div>
            @endif
        </div>

        <div class="data-section">
            <div class="section-header">
                <h2>Rekomendasi Penginapan Terbaru</h2>
                <a href="{{ route('admin.stays.create') }}" class="btn-add">+ Tambah Penginapan</a>
            </div>
            @if($stays->count() > 0)
                <input class="search-input" type="text" placeholder="Cari penginapan..." data-search-target="stays-table">
                <div class="table-scroll">
                    <table id="stays-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Harga</th>
                                <th>Rating</th>
                                <th>Status Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stays as $stay)
                                <tr>
                                    <td><strong>{{ $stay->name }}</strong></td>
                                    <td>{{ $stay->location }}</td>
                                    <td class="price">{{ (float) $stay->price <= 0 ? 'Gratis' : 'Rp ' . number_format($stay->price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($stay->user_rating_avg)
                                            ⭐ {{ number_format($stay->user_rating_avg, 2) }} ({{ $stay->ratings_count }})
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $stay->status_lokasi === 'hidden gem' ? 'status-active' : 'status-inactive' }}">
                                            {{ $stay->status_lokasi === 'hidden gem' ? 'Hidden Gem' : 'Terkenal' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('admin.stays.show', $stay) }}" class="btn-small btn-edit">Detail</a>
                                            <a href="{{ route('admin.stays.edit', $stay) }}" class="btn-small btn-edit">Edit</a>
                                            <form action="{{ route('admin.stays.destroy', $stay) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-small btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="no-search-result" data-empty-target="stays-table">Data tidak ditemukan.</div>
            @else
                <div class="empty-message">
                    <p>Belum ada data penginapan</p>
                </div>
            @endif
        </div>
        </div>
        </main>
    </div>

    <script>
        document.querySelectorAll('.search-input').forEach(function (input) {
            input.addEventListener('input', function () {
                var keyword = input.value.toLowerCase().trim();
                var tableId = input.getAttribute('data-search-target');
                var table = document.getElementById(tableId);

                if (!table) {
                    return;
                }

                var rows = table.querySelectorAll('tbody tr');
                var visibleCount = 0;

                rows.forEach(function (row) {
                    var text = row.textContent.toLowerCase();
                    var isMatch = text.indexOf(keyword) !== -1;
                    row.style.display = isMatch ? '' : 'none';
                    if (isMatch) {
                        visibleCount++;
                    }
                });

                var empty = document.querySelector('[data-empty-target="' + tableId + '"]');
                if (empty) {
                    empty.style.display = visibleCount === 0 ? 'block' : 'none';
                }
            });
        });
    </script>
</body>
</html>
