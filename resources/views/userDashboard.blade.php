<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }

        nav {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        nav h2 {
            font-size: 24px;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .nav-buttons a,
        .nav-buttons button {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .nav-buttons button.btn-primary {
            background: white;
            color: #667eea;
        }

        .nav-buttons button.btn-primary:hover {
            background: #f0f0f0;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .dashboard-header {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            color: #333;
            margin-bottom: 15px;
        }

        .user-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px;
            border-radius: 10px;
            color: white;
            margin-bottom: 20px;
        }

        .user-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .info-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 8px;
        }

        .info-label {
            font-size: 12px;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 18px;
            font-weight: 600;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: block;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .feature-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .feature-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-card h3 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .btn-link {
            display: inline-block;
            padding: 8px 15px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-link:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <nav>
        <h2>🏖️ Travel & Food Guide</h2>
        <div class="nav-buttons">
            <span style="color: white; font-weight: 600;">
                Selamat datang, {{ Auth::user()->username }}!
            </span>
            <form action="/logout" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-primary">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="dashboard-header">
            <h1>Dashboard Saya</h1>
            <p>Kelola profil dan aktivitas Anda</p>
        </div>

        <div class="user-card">
            <h2>Informasi Akun Anda</h2>
            <div class="user-info">
                <div class="info-item">
                    <div class="info-label">Username</div>
                    <div class="info-value">{{ Auth::user()->username }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ Auth::user()->email }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Role</div>
                    <div class="info-value">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Member Sejak</div>
                    <div class="info-value">{{ Auth::user()->created_at->format('d M Y') }}</div>
                </div>
            </div>
        </div>

        @if (Auth::user()->is_comment_blocked)
            <div class="alert alert-warning">
                <strong>⚠️ Akun Anda Diblokir</strong><br>
                Anda saat ini tidak dapat memberikan komentar.<br>
                <strong>Alasan:</strong> {{ Auth::user()->comment_blocked_reason }}<br>
                <strong>Diblokir pada:</strong> {{ Auth::user()->comment_blocked_at->format('d M Y H:i') }}
            </div>
        @else
            <div class="alert alert-success">
                ✓ Akun Anda aktif dan dapat memberikan komentar.
            </div>
        @endif

        <h2 style="margin: 40px 0 20px 0; color: #333;">Fitur Utama</h2>

        <div class="feature-list">
            <div class="feature-card">
                <h3>📍 Jelajahi Destinasi</h3>
                <p>Temukan destinasi wisata terbaik dan hidden gem di berbagai daerah dengan rating dan review dari user lain.</p>
                <a href="{{ route('explore.destinations') }}" class="btn-link">Lihat Destinasi</a>
            </div>

            <div class="feature-card">
                <h3>🍽️ Rekomendasi Kuliner</h3>
                <p>Cari tempat makan terbaik berdasarkan kategori dan nikmati pengalaman kuliner yang tak terlupakan.</p>
                <a href="{{ route('explore.culinaries') }}" class="btn-link">Lihat Kuliner</a>
            </div>

            <div class="feature-card">
                <h3>🏨 Akomodasi Menginap</h3>
                <p>Temukan penginapan terbaik dengan harga terjangkau dan fasilitas lengkap untuk perjalanan Anda.</p>
                <a href="{{ route('explore.stays') }}" class="btn-link">Lihat Penginapan</a>
            </div>

            <div class="feature-card">
                <h3>🔖 Bookmark Favorit</h3>
                <p>Simpan tempat favorit Anda dan buka lagi kapan saja dari satu halaman khusus favorit.</p>
                <a href="{{ route('bookmarks.index') }}" class="btn-link">Lihat Bookmark</a>
            </div>

            <div class="feature-card">
                <h3>💬 Berikan Komentar</h3>
                <p>Bagikan pengalaman Anda melalui komentar dan review untuk membantu traveler lain.</p>
                @if (Auth::user()->is_comment_blocked)
                    <span style="color: #d9534f; font-size: 14px;">⚠️ Akun Anda tidak dapat memberikan komentar</span>
                @else
                    <a href="#" class="btn-link">Tulis Komentar</a>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
