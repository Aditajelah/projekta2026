<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projekta Travel Guide</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f6f2e8;
            --ink: #122018;
            --muted: #48584e;
            --brand: #0b6e4f;
            --brand-2: #f28f3b;
            --panel: #fffaf0;
            --line: #d8ceb9;
            --shadow: 0 20px 45px rgba(13, 33, 24, 0.16);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 15% -10%, #ffe4b6 0%, transparent 45%),
                radial-gradient(circle at 80% 20%, #bde6d8 0%, transparent 40%),
                var(--bg);
            min-height: 100vh;
        }

        .wrap {
            max-width: 1160px;
            margin: 0 auto;
            padding: 24px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
        }

        .brand {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            letter-spacing: 0.02em;
            color: var(--ink);
            text-decoration: none;
        }

        .nav {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn {
            border: 1px solid var(--line);
            background: #ffffffcc;
            color: var(--ink);
            padding: 10px 16px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.92rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(18, 32, 24, 0.12);
            background: #fff;
        }

        .btn.primary {
            border-color: var(--brand);
            background: linear-gradient(130deg, var(--brand), #0f845f);
            color: #fff;
        }

        .hero {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 28px;
            align-items: stretch;
        }

        .hero-copy,
        .hero-card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 28px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .hero-copy {
            padding: 42px;
            position: relative;
            animation: rise 0.7s ease both;
        }

        .kicker {
            display: inline-block;
            background: #e8f5ef;
            color: #1f5f48;
            border: 1px solid #b9d7ca;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border-radius: 999px;
            padding: 8px 12px;
            margin-bottom: 14px;
        }

        h1 {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: clamp(2rem, 4vw, 3.4rem);
            line-height: 1.12;
            margin-bottom: 14px;
        }

        .lead {
            color: var(--muted);
            font-size: 1.04rem;
            line-height: 1.7;
            margin-bottom: 24px;
            max-width: 52ch;
        }

        .cta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
        }

        .chips {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .chip {
            border: 1px dashed #9fb6aa;
            color: #315548;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 0.85rem;
            background: #f6fbf8;
        }

        .hero-card {
            display: grid;
            grid-template-rows: 1fr auto;
            animation: rise 0.85s ease both;
        }

        .image-stage {
            padding: 22px;
            background:
                linear-gradient(140deg, #0f7c5b 0%, #144d3c 60%, #103327 100%);
            position: relative;
            min-height: 300px;
        }

        .image-stage::before,
        .image-stage::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            filter: blur(1px);
        }

        .image-stage::before {
            width: 170px;
            height: 170px;
            background: rgba(242, 143, 59, 0.28);
            top: -42px;
            right: -38px;
        }

        .image-stage::after {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.16);
            bottom: 26px;
            left: 18px;
        }

        .spot {
            height: 100%;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 18px;
            color: #e8f7ef;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            gap: 8px;
            position: relative;
            z-index: 2;
        }

        .spot h2 {
            font-family: 'Sora', sans-serif;
            font-size: 1.6rem;
            line-height: 1.2;
        }

        .spot p {
            color: #d7eee4;
            line-height: 1.55;
            font-size: 0.96rem;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            border-top: 1px solid var(--line);
        }

        .stat {
            padding: 16px;
            text-align: center;
            background: #fffdf8;
        }

        .stat strong {
            display: block;
            font-family: 'Sora', sans-serif;
            font-size: 1.2rem;
            margin-bottom: 3px;
        }

        .stat span {
            color: var(--muted);
            font-size: 0.84rem;
        }

        .feature-strip {
            margin-top: 30px;
            background: #fffbf3;
            border: 1px solid var(--line);
            border-radius: 24px;
            padding: 22px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            animation: rise 1s ease both;
        }

        .feature {
            border: 1px solid #eadfca;
            border-radius: 16px;
            background: #fff;
            padding: 16px;
        }

        .feature h3 {
            font-family: 'Sora', sans-serif;
            font-size: 1rem;
            margin-bottom: 8px;
        }

        .feature p {
            color: var(--muted);
            font-size: 0.92rem;
            line-height: 1.6;
        }

        .top-rated {
            margin-top: 30px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 24px;
            padding: 22px;
        }

        .top-rated h2 {
            font-family: 'Sora', sans-serif;
            margin-bottom: 16px;
            font-size: 1.35rem;
        }

        .top-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .top-card {
            border: 1px solid #eadfca;
            border-radius: 14px;
            padding: 14px;
            background: #fffaf3;
        }

        .top-card h3 {
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .top-card ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding-left: 0;
        }

        .top-card li {
            font-size: 0.92rem;
            color: #2c3d35;
            border-bottom: 1px dashed #e7dbc5;
            padding-bottom: 6px;
        }

        .empty-note {
            font-size: 0.9rem;
            color: var(--muted);
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 980px) {
            .hero {
                grid-template-columns: 1fr;
            }

            .feature-strip {
                grid-template-columns: 1fr;
            }

            .top-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .wrap {
                padding: 14px;
            }

            .hero-copy {
                padding: 24px;
                border-radius: 20px;
            }

            .hero-card {
                border-radius: 20px;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <header class="topbar">
            <a class="brand" href="/">Projekta Travel Guide</a>
            <nav class="nav">
                @if (Route::has('login'))
                    @auth
                        <a class="btn primary" href="{{ route('dashboard') }}">Dashboard</a>
                    @else
                        <a class="btn" href="{{ route('login') }}">Masuk</a>
                        @if (Route::has('register'))
                            <a class="btn primary" href="{{ route('register') }}">Daftar</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </header>

        <section class="hero">
            <article class="hero-copy">
                <span class="kicker">Jelajah Nusantara</span>
                <h1>Temukan destinasi, kuliner, dan penginapan favoritmu dalam satu platform.</h1>
                <p class="lead">
                    Rancang perjalanan dengan lebih cepat. Cari hidden gem, simpan spot terbaik,
                    dan lihat rekomendasi yang relevan untuk gaya liburanmu.
                </p>

                <div class="cta-row">
                    @auth
                        <a class="btn primary" href="{{ route('dashboard') }}">Buka Dashboard</a>
                    @else
                        <a class="btn primary" href="{{ route('register') }}">Mulai Gratis</a>
                        <a class="btn" href="{{ route('login') }}">Sudah punya akun</a>
                    @endauth
                </div>

                <div class="chips">
                    <span class="chip">Rute cerdas</span>
                    <span class="chip">Harga transparan</span>
                    <span class="chip">Hidden gem</span>
                </div>
            </article>

            <article class="hero-card">
                <div class="image-stage">
                    <div class="spot">
                        <h2>Curated by locals, approved by travelers.</h2>
                        <p>
                            Mulai dari pantai tenang sampai kuliner legendaris, semua rekomendasi
                            dibuat agar kamu bisa liburan tanpa bingung.
                        </p>
                    </div>
                </div>
                <div class="stats">
                    <div class="stat">
                        <strong>{{ $destinationCount ?? 0 }}</strong>
                        <span>Destinasi</span>
                    </div>
                    <div class="stat">
                        <strong>{{ $culinaryCount ?? 0 }}</strong>
                        <span>Kuliner</span>
                    </div>
                    <div class="stat">
                        <strong>{{ $stayCount ?? 0 }}</strong>
                        <span>Penginapan</span>
                    </div>
                </div>
            </article>
        </section>

        <section class="feature-strip">
            <article class="feature">
                <h3>Rencana yang fleksibel</h3>
                <p>Gabungkan destinasi, kuliner, dan penginapan ke itinerary pribadi dalam hitungan menit.</p>
            </article>
            <article class="feature">
                <h3>Rekomendasi tajam</h3>
                <p>Sistem menonjolkan lokasi paling relevan berdasarkan rating, harga, dan status hidden gem.</p>
            </article>
            <article class="feature">
                <h3>Siap dipakai tim admin</h3>
                <p>Konten mudah dikelola lewat dashboard admin terpisah tanpa mengganggu pengalaman user.</p>
            </article>
        </section>

        <section class="top-rated">
            <h2>Top Rated by Users</h2>
            <div class="top-grid">
                <article class="top-card">
                    <h3>📍 Destinasi</h3>
                    @if(isset($topDestinations) && $topDestinations->count() > 0)
                        <ul>
                            @foreach($topDestinations as $item)
                                <li>{{ $item->name }} - ⭐ {{ number_format($item->user_rating_avg, 2) }} ({{ $item->ratings_count }} rating)</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="empty-note">Belum ada rating dari user.</p>
                    @endif
                </article>

                <article class="top-card">
                    <h3>🍽️ Kuliner</h3>
                    @if(isset($topCulinaries) && $topCulinaries->count() > 0)
                        <ul>
                            @foreach($topCulinaries as $item)
                                <li>{{ $item->name }} - ⭐ {{ number_format($item->user_rating_avg, 2) }} ({{ $item->ratings_count }} rating)</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="empty-note">Belum ada rating dari user.</p>
                    @endif
                </article>

                <article class="top-card">
                    <h3>🏨 Penginapan</h3>
                    @if(isset($topStays) && $topStays->count() > 0)
                        <ul>
                            @foreach($topStays as $item)
                                <li>{{ $item->name }} - ⭐ {{ number_format($item->user_rating_avg, 2) }} ({{ $item->ratings_count }} rating)</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="empty-note">Belum ada rating dari user.</p>
                    @endif
                </article>
            </div>
        </section>
    </div>
</body>
</html>
