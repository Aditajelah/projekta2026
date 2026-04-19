<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinasi</title>
    <style>
        :root {
            --bg: #f2f6f5;
            --paper: #ffffff;
            --text: #1d2a2a;
            --muted: #5f6d6d;
            --accent: #0d9488;
            --accent-dark: #0f766e;
            --line: #dbe7e6;
        }
        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top right, #e9f8f4 0%, var(--bg) 45%, #edf3f7 100%);
            margin: 0;
            color: var(--text);
        }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px 24px; }
        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background: linear-gradient(110deg, #ffffff 0%, #e8fbf5 100%);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 14px 16px;
        }
        .top h1 { margin: 0; font-size: 26px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 18px; }
        .card {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 12px 24px rgba(10, 30, 40, .08);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 34px rgba(10, 30, 40, .14);
        }
        .thumb {
            width: 100%;
            height: 170px;
            object-fit: cover;
            display: block;
            background: #e9efef;
        }
        .thumb-empty {
            width: 100%;
            height: 170px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #d8f3ec 0%, #c7e8ff 100%);
            color: #23645f;
            font-weight: 600;
            letter-spacing: .3px;
        }
        .card-body { padding: 14px; }
        .card h3 { margin: 0 0 8px 0; font-size: 19px; }
        .meta {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 7px;
            line-height: 1.45;
        }
        .chips { display: flex; flex-wrap: wrap; gap: 7px; margin: 10px 0 12px; }
        .chip {
            font-size: 12px;
            background: #f1f8f7;
            border: 1px solid #d2e7e5;
            color: #275f5b;
            padding: 4px 8px;
            border-radius: 999px;
        }
        .btn {
            display: inline-block;
            padding: 9px 13px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
        }
        .back { color: #1f4b49; text-decoration: none; font-weight: 600; }
        @media (max-width: 640px) {
            .container { margin-top: 18px; }
            .top { flex-direction: column; align-items: flex-start; gap: 10px; }
            .top h1 { font-size: 22px; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="top">
        <h1>📍 Destinasi</h1>
        <a class="back" href="{{ route('user.dashboard') }}">← Dashboard</a>
    </div>

    <div class="grid">
        @foreach($items as $item)
            <div class="card">
                @php
                    $rawImage = $item->image_url;
                    $imageSrc = !empty($rawImage)
                        ? ((str_starts_with($rawImage, 'http://') || str_starts_with($rawImage, 'https://')) ? $rawImage : asset('storage/' . $rawImage))
                        : null;
                @endphp

                @if($imageSrc)
                    <img class="thumb" src="{{ $imageSrc }}" alt="Foto {{ $item->name }}">
                @else
                    <div class="thumb-empty">Belum Ada Foto</div>
                @endif

                <div class="card-body">
                    <h3>{{ $item->name }}</h3>
                    <div class="meta">{{ $item->location }}</div>
                    <div class="chips">
                        <span class="chip">Kategori: {{ $item->category ?: '-' }}</span>
                        <span class="chip">Rating: {{ $item->user_rating_avg ? number_format($item->user_rating_avg, 2) : '-' }}</span>
                        <span class="chip">Ulasan: {{ $item->ratings_count }}</span>
                    </div>
                    <a class="btn" href="{{ route('explore.destinations.show', $item) }}">Lihat Detail</a>
                </div>
            </div>
        @endforeach
    </div>

    <div style="margin-top:18px;">{{ $items->links() }}</div>
</div>
</body>
</html>
