<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kuliner</title>
    <style>
        :root {
            --bg: #fff8ef;
            --paper: #ffffff;
            --text: #2f2620;
            --muted: #6d5f54;
            --line: #f2dfcf;
            --accent: #ea580c;
            --accent-dark: #c2410c;
        }
        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top right, #fff1dc 0%, var(--bg) 42%, #fffdf8 100%);
            margin: 0;
            color: var(--text);
        }
        .container { max-width: 1000px; margin: 26px auto; padding: 0 20px 24px; }
        .alert {
            background: #fff4e7;
            color: #8a4a20;
            border: 1px solid #f6d8bb;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 14px;
        }
        .layout {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 14px 30px rgba(44, 28, 10, .10);
        }
        .hero {
            width: 100%;
            height: 310px;
            object-fit: cover;
            display: block;
            background: #faece0;
        }
        .hero-empty {
            height: 310px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ffe3c2 0%, #ffd7b5 100%);
            color: #8a4a20;
            font-weight: 700;
            letter-spacing: .4px;
        }
        .content { padding: 18px; }
        .title { margin: 2px 0 8px; font-size: 30px; line-height: 1.2; }
        .sub { color: var(--muted); margin: 0 0 12px; }
        .chips { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }
        .chip {
            font-size: 12px;
            background: #fff6ee;
            border: 1px solid #f2dbc6;
            color: #7f4b26;
            padding: 5px 9px;
            border-radius: 999px;
        }
        .panel {
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 14px;
            background: #fffcf8;
        }
        .panel h3 { margin: 0 0 10px; font-size: 18px; }
        .row {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .label { color: #634c38; font-weight: 600; }
        .value { color: var(--text); }
        .rating-box {
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 14px;
            background: #fff9f2;
        }
        .rating-box h3 { margin: 0 0 10px; }
        select, textarea {
            width: 100%;
            border: 1px solid #edd3be;
            border-radius: 10px;
            padding: 9px 10px;
            font-family: inherit;
            background: #fff;
        }
        textarea { min-height: 110px; resize: vertical; }
        .btn {
            margin-top: 10px;
            padding: 10px 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: #fff;
            font-weight: 600;
            cursor: pointer;
        }
        .back {
            display: inline-block;
            margin-top: 14px;
            color: #7a3d1b;
            text-decoration: none;
            font-weight: 600;
        }
        @media (max-width: 700px) {
            .hero, .hero-empty { height: 230px; }
            .title { font-size: 24px; }
            .row { grid-template-columns: 1fr; gap: 4px; }
        }
    </style>
</head>
<body>
<div class="container">
    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    @php
        $rawImage = $culinary->image_url;
        $imageSrc = !empty($rawImage)
            ? ((str_starts_with($rawImage, 'http://') || str_starts_with($rawImage, 'https://')) ? $rawImage : asset('storage/' . $rawImage))
            : null;
    @endphp

    <div class="layout">
        @if($imageSrc)
            <img class="hero" src="{{ $imageSrc }}" alt="Foto {{ $culinary->name }}">
        @else
            <div class="hero-empty">Belum Ada Foto</div>
        @endif

        <div class="content">
            <h1 class="title">{{ $culinary->name }}</h1>
            <p class="sub">{{ $culinary->location }}</p>

            <div class="chips">
                <span class="chip">Kategori: {{ $culinary->cuisine_type ?: '-' }}</span>
                <span class="chip">Harga: {{ $culinary->price }}</span>
                <span class="chip">Rating User: {{ $avgRating ? number_format($avgRating, 2) : '-' }}</span>
            </div>

            <div style="margin-bottom:14px;">
                @if($isBookmarked)
                    <form method="POST" action="{{ route('bookmarks.destroy', ['type' => 'culinary', 'id' => $culinary->id_culinaries]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn" type="submit" style="background: linear-gradient(135deg, #ef4444, #dc2626);">Hapus dari Bookmark</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('bookmarks.store', ['type' => 'culinary', 'id' => $culinary->id_culinaries]) }}">
                        @csrf
                        <button class="btn" type="submit">Simpan ke Bookmark</button>
                    </form>
                @endif
            </div>

            <div class="panel">
                <h3>Informasi Kuliner</h3>
                <div class="row"><div class="label">Alamat</div><div class="value">{{ $culinary->place_address ?: '-' }}, {{ $culinary->city ?: '-' }}, {{ $culinary->province ?: '-' }}</div></div>
                <div class="row"><div class="label">Hari Operasional</div><div class="value">{{ $culinary->operational_days ?: '-' }}</div></div>
                <div class="row"><div class="label">Jam Operasional</div><div class="value">{{ $culinary->operational_hours ?: '-' }}</div></div>
                <div class="row"><div class="label">Transportasi</div><div class="value">{{ !empty($culinary->transport_modes) ? implode(', ', $culinary->transport_modes) : '-' }}</div></div>
                <div class="row"><div class="label">Fasilitas</div><div class="value">{{ $culinary->amenities ?: '-' }}</div></div>
                <div class="row"><div class="label">Deskripsi</div><div class="value">{{ $culinary->description ?: '-' }}</div></div>
            </div>

            <div class="rating-box">
                <h3>Beri Rating Anda</h3>
                <form method="POST" action="{{ route('ratings.store', ['type' => 'culinary', 'id' => $culinary->id_culinaries]) }}">
                    @csrf
                    <label for="rating">Rating (1-5)</label>
                    <select name="rating" id="rating" required>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ (int) old('rating', optional($userRating)->rating) === $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>

                    <label for="review" style="display:block; margin-top:10px;">Komentar</label>
                    <textarea name="review" id="review" rows="4">{{ old('review', optional($userRating)->review) }}</textarea>

                    <button class="btn" type="submit">Simpan Rating</button>
                </form>
            </div>
        </div>
    </div>

    <a class="back" href="{{ route('explore.culinaries') }}">← Kembali ke daftar</a>
</div>
</body>
</html>
