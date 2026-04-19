<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penginapan</title>
    <style>
        :root {
            --bg: #f4f7ff;
            --paper: #ffffff;
            --text: #202739;
            --muted: #5c6580;
            --line: #dce4f6;
            --accent: #2563eb;
            --accent-dark: #1d4ed8;
        }
        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top right, #e8eeff 0%, var(--bg) 42%, #f8faff 100%);
            margin: 0;
            color: var(--text);
        }
        .container { max-width: 1000px; margin: 26px auto; padding: 0 20px 24px; }
        .alert {
            background: #edf3ff;
            color: #31549b;
            border: 1px solid #cfddfb;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 14px;
        }
        .layout {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 14px 30px rgba(20, 35, 70, .10);
        }
        .hero {
            width: 100%;
            height: 310px;
            object-fit: cover;
            display: block;
            background: #e9eef9;
        }
        .hero-empty {
            height: 310px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #d9e5ff 0%, #d1f1f6 100%);
            color: #2d4b8d;
            font-weight: 700;
            letter-spacing: .4px;
        }
        .content { padding: 18px; }
        .title { margin: 2px 0 8px; font-size: 30px; line-height: 1.2; }
        .sub { color: var(--muted); margin: 0 0 12px; }
        .chips { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }
        .chip {
            font-size: 12px;
            background: #f1f5ff;
            border: 1px solid #d7e1fb;
            color: #2d4d93;
            padding: 5px 9px;
            border-radius: 999px;
        }
        .panel {
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 14px;
            background: #fbfdff;
        }
        .panel h3 { margin: 0 0 10px; font-size: 18px; }
        .row {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .label { color: #445074; font-weight: 600; }
        .value { color: var(--text); }
        .rating-box {
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 14px;
            background: #f7f9ff;
        }
        .rating-box h3 { margin: 0 0 10px; }
        select, textarea {
            width: 100%;
            border: 1px solid #ccd8f4;
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
            color: #23448b;
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
        $rawImage = $stay->image_url;
        $imageSrc = !empty($rawImage)
            ? ((str_starts_with($rawImage, 'http://') || str_starts_with($rawImage, 'https://')) ? $rawImage : asset('storage/' . $rawImage))
            : null;
    @endphp

    <div class="layout">
        @if($imageSrc)
            <img class="hero" src="{{ $imageSrc }}" alt="Foto {{ $stay->name }}">
        @else
            <div class="hero-empty">Belum Ada Foto</div>
        @endif

        <div class="content">
            <h1 class="title">{{ $stay->name }}</h1>
            <p class="sub">{{ $stay->location }}</p>

            <div class="chips">
                <span class="chip">Harga: {{ $stay->price }}</span>
                <span class="chip">Fasilitas: {{ $stay->amenities ?: '-' }}</span>
                <span class="chip">Rating User: {{ $avgRating ? number_format($avgRating, 2) : '-' }}</span>
            </div>

            <div style="margin-bottom:14px;">
                @if($isBookmarked)
                    <form method="POST" action="{{ route('bookmarks.destroy', ['type' => 'stay', 'id' => $stay->id_stays]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn" type="submit" style="background: linear-gradient(135deg, #ef4444, #dc2626);">Hapus dari Bookmark</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('bookmarks.store', ['type' => 'stay', 'id' => $stay->id_stays]) }}">
                        @csrf
                        <button class="btn" type="submit">Simpan ke Bookmark</button>
                    </form>
                @endif
            </div>

            <div class="panel">
                <h3>Informasi Penginapan</h3>
                <div class="row"><div class="label">Alamat</div><div class="value">{{ $stay->place_address ?: '-' }}, {{ $stay->city ?: '-' }}, {{ $stay->province ?: '-' }}</div></div>
                <div class="row"><div class="label">Hari Operasional</div><div class="value">{{ $stay->operational_days ?: '-' }}</div></div>
                <div class="row"><div class="label">Jam Operasional</div><div class="value">{{ $stay->operational_hours ?: '-' }}</div></div>
                <div class="row"><div class="label">Transportasi</div><div class="value">{{ !empty($stay->transport_modes) ? implode(', ', $stay->transport_modes) : '-' }}</div></div>
                <div class="row"><div class="label">Deskripsi</div><div class="value">{{ $stay->description ?: '-' }}</div></div>
            </div>

            <div class="rating-box">
                <h3>Beri Rating Anda</h3>
                <form method="POST" action="{{ route('ratings.store', ['type' => 'stay', 'id' => $stay->id_stays]) }}">
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

    <a class="back" href="{{ route('explore.stays') }}">← Kembali ke daftar</a>
</div>
</body>
</html>
