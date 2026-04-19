<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Destinasi</title>
    <style>
        :root {
            --bg: #f2f6f5;
            --paper: #ffffff;
            --text: #1d2a2a;
            --muted: #5f6d6d;
            --line: #dbe7e6;
            --accent: #0d9488;
            --accent-dark: #0f766e;
        }
        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top right, #e9f8f4 0%, var(--bg) 45%, #edf3f7 100%);
            margin: 0;
            color: var(--text);
        }
        .container { max-width: 1000px; margin: 26px auto; padding: 0 20px 24px; }
        .alert {
            background: #e6f9f3;
            color: #145a4f;
            border: 1px solid #b9eadf;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 14px;
        }
        .layout {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 14px 30px rgba(12, 40, 44, .10);
        }
        .hero {
            width: 100%;
            height: 310px;
            object-fit: cover;
            display: block;
            background: #e7f0ef;
        }
        .hero-empty {
            height: 310px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #d8f3ec 0%, #c7e8ff 100%);
            color: #23645f;
            font-weight: 700;
            letter-spacing: .4px;
        }
        .content { padding: 18px; }
        .title { margin: 2px 0 8px; font-size: 30px; line-height: 1.2; }
        .sub { color: var(--muted); margin: 0 0 12px; }
        .chips { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }
        .chip {
            font-size: 12px;
            background: #f1f8f7;
            border: 1px solid #d2e7e5;
            color: #275f5b;
            padding: 5px 9px;
            border-radius: 999px;
        }
        .panel {
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 14px;
            background: #fcfefe;
        }
        .panel h3 { margin: 0 0 10px; font-size: 18px; }
        .row {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .label { color: #3f5050; font-weight: 600; }
        .value { color: var(--text); }
        .rating-box {
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 14px;
            background: #f8fdfc;
        }
        .rating-box h3 { margin: 0 0 10px; }
        select, textarea {
            width: 100%;
            border: 1px solid #cfe0de;
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
            color: #1f4b49;
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
        $rawImage = $destination->image_url;
        $imageSrc = !empty($rawImage)
            ? ((str_starts_with($rawImage, 'http://') || str_starts_with($rawImage, 'https://')) ? $rawImage : asset('storage/' . $rawImage))
            : null;
    @endphp

    <div class="layout">
        @if($imageSrc)
            <img class="hero" src="{{ $imageSrc }}" alt="Foto {{ $destination->name }}">
        @else
            <div class="hero-empty">Belum Ada Foto</div>
        @endif

        <div class="content">
            <h1 class="title">{{ $destination->name }}</h1>
            <p class="sub">{{ $destination->location }}</p>

            <div class="chips">
                <span class="chip">Kategori: {{ $destination->category ?: '-' }}</span>
                <span class="chip">Harga: {{ $destination->price }}</span>
                <span class="chip">Rating User: {{ $avgRating ? number_format($avgRating, 2) : '-' }}</span>
            </div>

            <div style="margin-bottom:14px;">
                @if($isBookmarked)
                    <form method="POST" action="{{ route('bookmarks.destroy', ['type' => 'destination', 'id' => $destination->id_destinations]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn" type="submit" style="background: linear-gradient(135deg, #ef4444, #dc2626);">Hapus dari Bookmark</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('bookmarks.store', ['type' => 'destination', 'id' => $destination->id_destinations]) }}">
                        @csrf
                        <button class="btn" type="submit">Simpan ke Bookmark</button>
                    </form>
                @endif
            </div>

            <div class="panel">
                <h3>Informasi Destinasi</h3>
                <div class="row"><div class="label">Alamat</div><div class="value">{{ $destination->place_address ?: '-' }}, {{ $destination->city ?: '-' }}, {{ $destination->province ?: '-' }}</div></div>
                <div class="row"><div class="label">Hari Operasional</div><div class="value">{{ $destination->operational_days ?: '-' }}</div></div>
                <div class="row"><div class="label">Jam Operasional</div><div class="value">{{ $destination->operational_hours ?: '-' }}</div></div>
                <div class="row"><div class="label">Transportasi</div><div class="value">{{ !empty($destination->transport_modes) ? implode(', ', $destination->transport_modes) : '-' }}</div></div>
                <div class="row"><div class="label">Deskripsi</div><div class="value">{{ $destination->description ?: '-' }}</div></div>
            </div>

            <div class="rating-box">
                <h3>Beri Rating Anda</h3>
                <form method="POST" action="{{ route('ratings.store', ['type' => 'destination', 'id' => $destination->id_destinations]) }}">
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

    <a class="back" href="{{ route('explore.destinations') }}">← Kembali ke daftar</a>
</div>
</body>
</html>
