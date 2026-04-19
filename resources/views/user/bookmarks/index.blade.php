<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorit Saya</title>
    <style>
        :root {
            --bg: #f7f8fc;
            --paper: #ffffff;
            --text: #1d2640;
            --muted: #5b6484;
            --line: #dde3f6;
            --accent: #2563eb;
            --danger: #dc2626;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top left, #edf2ff 0%, var(--bg) 40%, #fafbff 100%);
            color: var(--text);
        }
        .container { max-width: 1150px; margin: 28px auto; padding: 0 20px 20px; }
        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 12px 14px;
        }
        .top h1 { margin: 0; font-size: 26px; }
        .back { color: #2f4f9e; text-decoration: none; font-weight: 600; }
        .alert {
            background: #eaf2ff;
            color: #254b9a;
            border: 1px solid #ccdcff;
            border-radius: 10px;
            padding: 11px 12px;
            margin-bottom: 14px;
        }
        .empty {
            background: #fff;
            border: 1px dashed var(--line);
            border-radius: 14px;
            padding: 36px;
            text-align: center;
            color: var(--muted);
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
        }
        .card {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 10px 22px rgba(20, 34, 70, .08);
        }
        .thumb {
            width: 100%;
            height: 170px;
            object-fit: cover;
            display: block;
            background: #ecf0fb;
        }
        .thumb-empty {
            width: 100%;
            height: 170px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #d9e5ff 0%, #d6ecff 100%);
            color: #31549b;
            font-weight: 600;
        }
        .body { padding: 13px; }
        .type {
            display: inline-block;
            background: #eef4ff;
            color: #2f4f9e;
            border: 1px solid #d9e6ff;
            border-radius: 999px;
            padding: 3px 8px;
            font-size: 12px;
            margin-bottom: 8px;
        }
        .name { margin: 0 0 8px; font-size: 19px; }
        .meta { color: var(--muted); font-size: 13px; margin-bottom: 10px; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn {
            border: none;
            border-radius: 9px;
            padding: 8px 11px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
        }
        .btn-view { background: var(--accent); color: #fff; }
        .btn-remove { background: #fee2e2; color: var(--danger); }
        @media (max-width: 640px) {
            .top { flex-direction: column; align-items: flex-start; }
            .top h1 { font-size: 22px; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="top">
        <h1>Bookmark Favorit</h1>
        <a class="back" href="{{ route('user.dashboard') }}">← Kembali ke Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    @if($bookmarks->isEmpty())
        <div class="empty">
            Belum ada favorit. Tambahkan tempat dari halaman detail destinasi, kuliner, atau penginapan.
        </div>
    @else
        <div class="grid">
            @foreach($bookmarks as $bookmark)
                @php
                    $item = $bookmark->bookmarkable;
                @endphp

                @if($item)
                    @php
                        $type = match (get_class($item)) {
                            App\Models\Destination::class => 'destination',
                            App\Models\Culinary::class => 'culinary',
                            App\Models\Stay::class => 'stay',
                            default => null,
                        };

                        $typeLabel = match ($type) {
                            'destination' => 'Destinasi',
                            'culinary' => 'Kuliner',
                            'stay' => 'Penginapan',
                            default => 'Tempat',
                        };

                        $detailRoute = match ($type) {
                            'destination' => route('explore.destinations.show', $item),
                            'culinary' => route('explore.culinaries.show', $item),
                            'stay' => route('explore.stays.show', $item),
                            default => '#',
                        };

                        $rawImage = $item->image_url ?? null;
                        $imageSrc = !empty($rawImage)
                            ? ((str_starts_with($rawImage, 'http://') || str_starts_with($rawImage, 'https://')) ? $rawImage : asset('storage/' . $rawImage))
                            : null;
                    @endphp

                    <div class="card">
                        @if($imageSrc)
                            <img class="thumb" src="{{ $imageSrc }}" alt="Foto {{ $item->name }}">
                        @else
                            <div class="thumb-empty">Belum Ada Foto</div>
                        @endif

                        <div class="body">
                            <span class="type">{{ $typeLabel }}</span>
                            <h3 class="name">{{ $item->name }}</h3>
                            <div class="meta">{{ $item->location ?? '-' }}</div>

                            <div class="actions">
                                <a class="btn btn-view" href="{{ $detailRoute }}">Lihat Detail</a>
                                @if($type)
                                    <form method="POST" action="{{ route('bookmarks.destroy', ['type' => $type, 'id' => $item->getKey()]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-remove" type="submit">Hapus Favorit</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
</body>
</html>
