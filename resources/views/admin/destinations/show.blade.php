<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Destinasi</title>
    <style>
        :root {
            --bg-start: #f7f4ef;
            --bg-end: #eef5ff;
            --card: rgba(255, 255, 255, 0.92);
            --border: rgba(15, 23, 42, 0.08);
            --text: #102033;
            --muted: #607086;
            --primary: #1d4ed8;
        }

        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, var(--bg-start), var(--bg-end)); margin:0; color: var(--text); }
        .page-shell { max-width: 1100px; margin: 28px auto; padding: 0 18px 28px; }
        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.25fr) minmax(300px, 0.95fr);
            gap: 18px;
            align-items: stretch;
            margin-bottom: 18px;
        }
        .hero-card, .photo-card, .info-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 24px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(14px);
        }
        .hero-card { padding: 26px; }
        .eyebrow { display:inline-flex; margin:0 0 14px; padding:7px 12px; border-radius:999px; background:rgba(29,78,216,.08); color:var(--primary); font-size:12px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; }
        h1 { margin:0; font-size:34px; line-height:1.15; }
        .subtitle { margin:12px 0 0; color:var(--muted); line-height:1.6; max-width:60ch; }
        .meta-row { display:flex; flex-wrap:wrap; gap:10px; margin-top:18px; }
        .meta-pill { padding:9px 12px; border-radius:999px; background:rgba(15,23,42,.05); font-size:13px; font-weight:600; }
        .photo-card { overflow:hidden; }
        .photo-preview { width:100%; height:100%; min-height:320px; object-fit:cover; display:block; }
        .photo-placeholder { min-height:320px; display:flex; align-items:center; justify-content:center; padding:24px; text-align:center; color:var(--muted); background:linear-gradient(135deg, rgba(29,78,216,.08), rgba(21,128,61,.08)); }
        .photo-caption { margin:0; padding:14px 18px 18px; color:var(--muted); font-size:13px; }
        .info-card { padding: 22px; }
        .info-grid { display:grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap:16px; }
        .info-block { padding: 16px; border-radius: 18px; background: rgba(255,255,255,.76); border: 1px solid #e5ebf2; }
        .info-block .label { display:block; margin-bottom:6px; color:var(--muted); font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; }
        .info-block .value { color: var(--text); font-weight:600; line-height:1.65; word-break: break-word; }
        .section-title { margin: 0 0 6px; font-size: 18px; }
        .section-subtitle { margin: 0 0 18px; color: var(--muted); font-size: 14px; }
        .wide { grid-column: 1 / -1; }
        .actions { margin-top:22px; display:flex; gap:10px; flex-wrap:wrap; }
        .btn { padding:12px 16px; border:none; border-radius:12px; text-decoration:none; color:#fff; font-weight:700; }
        .btn-edit { background: linear-gradient(135deg, #2563eb, #60a5fa); }
        .btn-back { background:#e2e8f0; color: var(--text); }
        @media (max-width: 860px) { .hero, .info-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    @php
        $destinationImage = !empty($destination->image_url) ? asset('storage/' . $destination->image_url) : null;
    @endphp
    <div class="page-shell">
        <div class="hero">
            <div class="hero-card">
                <p class="eyebrow">Detail destinasi</p>
                <h1>{{ $destination->name }}</h1>
                <p class="subtitle">Ringkasan lengkap destinasi dengan foto utama di bagian atas agar informasi lebih cepat dibaca saat pengecekan data.</p>
                <div class="meta-row">
                    <span class="meta-pill">{{ $destination->category }}</span>
                    <span class="meta-pill">{{ $destination->status_lokasi }}</span>
                    <span class="meta-pill">{{ !empty($destination->price) && (float) $destination->price > 0 ? 'Rp ' . number_format($destination->price, 0, ',', '.') : 'Gratis' }}</span>
                </div>
            </div>
            <div class="photo-card">
                @if($destinationImage)
                    <img src="{{ $destinationImage }}" alt="Foto Destinasi" class="photo-preview">
                    <p class="photo-caption">Foto utama destinasi yang tersimpan saat ini.</p>
                @else
                    <div class="photo-placeholder">Belum ada foto destinasi.</div>
                @endif
            </div>
        </div>

        <div class="info-card">
            <h2 class="section-title">Informasi utama</h2>
            <p class="section-subtitle">Data lokasi, harga, transportasi, dan status ditampilkan dalam kartu agar lebih mudah dipindai.</p>
            <div class="info-grid">
                <div class="info-block"><span class="label">ID</span><div class="value">{{ $destination->id_destinations }}</div></div>
                <div class="info-block"><span class="label">Nama</span><div class="value">{{ $destination->name }}</div></div>
                <div class="info-block"><span class="label">Alamat Tempat</span><div class="value">{{ $destination->place_address }}</div></div>
                <div class="info-block"><span class="label">Kota/Kabupaten</span><div class="value">{{ $destination->city }}</div></div>
                <div class="info-block"><span class="label">Provinsi</span><div class="value">{{ $destination->province }}</div></div>
                <div class="info-block"><span class="label">Lokasi Gabungan</span><div class="value">{{ $destination->location }}</div></div>
                <div class="info-block"><span class="label">Latitude</span><div class="value">{{ $destination->latitude }}</div></div>
                <div class="info-block"><span class="label">Longitude</span><div class="value">{{ $destination->longitude }}</div></div>
                <div class="info-block wide">@include('partials.operational-schedule-display', ['model' => $destination])</div>
                <div class="info-block"><span class="label">Transport</span><div class="value">{{ !empty($destination->transport_modes) ? implode(', ', $destination->transport_modes) : '-' }}</div></div>
                <div class="info-block"><span class="label">Harga</span><div class="value">{{ !empty($destination->price) && (float) $destination->price > 0 ? 'Rp ' . number_format($destination->price, 0, ',', '.') : 'Gratis' }}</div></div>
                <div class="info-block"><span class="label">Rating</span><div class="value">{{ $destination->rating }}</div></div>
                <div class="info-block"><span class="label">Kategori</span><div class="value">{{ $destination->category }}</div></div>
                <div class="info-block wide"><span class="label">Deskripsi</span><div class="value">{{ $destination->description }}</div></div>
                <div class="info-block"><span class="label">Status Lokasi</span><div class="value">{{ $destination->status_lokasi }}</div></div>
                <div class="info-block"><span class="label">Created At</span><div class="value">{{ $destination->created_at }}</div></div>
                <div class="info-block"><span class="label">Updated At</span><div class="value">{{ $destination->updated_at }}</div></div>
            </div>

            <div class="actions">
                <a class="btn btn-edit" href="{{ route('admin.destinations.edit', $destination) }}">Edit</a>
                <a class="btn btn-back" href="{{ route('admin.dashboard') }}">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
