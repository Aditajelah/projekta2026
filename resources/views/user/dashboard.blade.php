<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        nav {
            background: rgba(0, 0, 0, 0.1);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            backdrop-filter: blur(10px);
        }

        nav h2 {
            font-size: 24px;
            font-weight: 600;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .nav-buttons button {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            background: white;
            color: #667eea;
        }

        .nav-buttons button:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .dashboard-header {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-bottom: 40px;
            text-align: center;
        }

        .dashboard-header h1 {
            color: #667eea;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .dashboard-header p {
            color: #999;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .user-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .user-info h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .info-item {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            border-left: 3px solid #667eea;
        }

        .info-label {
            color: #999;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .info-value {
            color: #333;
            font-size: 18px;
            font-weight: 600;
        }

        .content-section {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-bottom: 40px;
        }

        .content-section h2 {
            color: #333;
            margin-bottom: 30px;
            font-size: 24px;
            padding-bottom: 15px;
            border-bottom: 2px solid #667eea;
        }

        .quick-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .quick-link-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
        }

        .quick-link-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .quick-link-card h3 {
            margin-top: 15px;
            font-size: 18px;
        }

        .quick-link-icon {
            font-size: 40px;
        }

        .welcome-message {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
            margin-bottom: 30px;
        }

        .welcome-message h4 {
            color: #667eea;
            margin-bottom: 10px;
        }

        .welcome-message p {
            color: #666;
            line-height: 1.6;
        }

        .activity-item {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            background: #f0f0f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .activity-content h4 {
            color: #333;
            margin-bottom: 5px;
        }

        .activity-content p {
            color: #999;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .dashboard-header {
                padding: 30px;
            }

            .dashboard-header h1 {
                font-size: 24px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .quick-links {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav>
        <h2>✈️ Travel Guide</h2>
        <div class="nav-buttons">
            <span style="color: white; margin-right: 20px; font-weight: 600;">
                {{ Auth::user()->username }}
            </span>
            <form action="/logout" method="POST" style="display: inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <h1>Selamat Datang, {{ Auth::user()->username }}! 👋</h1>
            <p>Jelajahi destinasi, kuliner, dan penginapan terbaik bersama kami</p>

            <div class="user-info">
                <h3>Informasi Profil</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Username</div>
                        <div class="info-value">{{ Auth::user()->username }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Status Akun</div>
                        <div class="info-value">✓ Aktif</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Bergabung Sejak</div>
                        <div class="info-value">{{ Auth::user()->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Message -->
        <div class="welcome-message">
            <h4>📢 Selamat Datang di Travel Guide!</h4>
            <p>
                Website ini adalah panduan terbaik untuk menemukan destinasi wisata impian, kuliner lezat, 
                dan penginapan nyaman di berbagai daerah. Mulai jelajahi sekarang dan temukan pengalaman 
                perjalanan yang tak terlupakan bersama ribuan traveler lainnya.
            </p>
        </div>

        <!-- Quick Links Section -->
        <div class="content-section">
            <h2>🚀 Mulai Jelajahi</h2>
            <div class="quick-links">
                <a href="#" class="quick-link-card">
                    <div class="quick-link-icon">📍</div>
                    <h3>Destinasi Wisata</h3>
                    <p>Jelajahi destinasi wisata terbaik</p>
                </a>
                <a href="#" class="quick-link-card">
                    <div class="quick-link-icon">🍽️</div>
                    <h3>Rekomendasi Kuliner</h3>
                    <p>Temukan makanan lezat terbaik</p>
                </a>
                <a href="#" class="quick-link-card">
                    <div class="quick-link-icon">🏨</div>
                    <h3>Penginapan Nyaman</h3>
                    <p>Cari tempat menginap terbaik</p>
                </a>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="content-section">
            <h2>📊 Aktivitas Terakhir</h2>
            <div class="activity-item">
                <div class="activity-icon">👤</div>
                <div class="activity-content">
                    <h4>Akun Anda Dibuat</h4>
                    <p>{{ Auth::user()->created_at->format('d M Y \p\u006Bl H:i') }}</p>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">✅</div>
                <div class="activity-content">
                    <h4>Email Terverifikasi</h4>
                    <p>Akun Anda telah diaktifkan dan siap digunakan</p>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">🎯</div>
                <div class="activity-content">
                    <h4>Siap untuk Dijelajahi</h4>
                    <p>Mulai jelajahi destinasi dan kuliner favorit Anda sekarang!</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
