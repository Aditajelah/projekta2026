<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuliner</title>
    <style>
        :root {
            --bg: #fff8ef;
            --paper: #ffffff;
            --text: #2f2620;
            --muted: #6d5f54;
            --accent: #ea580c;
            --accent-dark: #c2410c;
            --line: #f2dfcf;
        }
        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top right, #fff1dc 0%, var(--bg) 40%, #fffdf8 100%);
            margin: 0;
            color: var(--text);
        }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px 24px; }
        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background: linear-gradient(120deg, #fff7ef 0%, #fff1e5 100%);
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
            box-shadow: 0 12px 24px rgba(40, 25, 10, .08);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 34px rgba(40, 25, 10, .14);
        }
        .thumb {
            width: 100%;
            height: 170px;
            object-fit: cover;
            display: block;
            background: #f7ece2;
        }
        .thumb-empty {
            width: 100%;
            height: 170px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ffe3c2 0%, #ffd7b5 100%);
            color: #8a4a20;
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
            background: #fff6ee;
            border: 1px solid #f2dbc6;
            color: #7f4b26;
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
        .back { color: #7a3d1b; text-decoration: none; font-weight: 600; }
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
        <h1>🍽️ Kuliner</h1>
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
                        <span class="chip">Kategori: {{ $item->cuisine_type ?: '-' }}</span>
                        <span class="chip">Rating: {{ $item->user_rating_avg ? number_format($item->user_rating_avg, 2) : '-' }}</span>
                        <span class="chip">Ulasan: {{ $item->ratings_count }}</span>
                    </div>
                    <a class="btn" href="{{ route('explore.culinaries.show', $item) }}">Lihat Detail</a>
                </div>
            </div>
        @endforeach
    </div>

    <div style="margin-top:18px;">{{ $items->links() }}</div>
</div>
</body>
</html>
