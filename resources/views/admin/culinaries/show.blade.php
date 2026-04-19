<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kuliner</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background:#f5f5f5; margin:0; }
        .container { max-width: 900px; margin: 30px auto; background:#fff; padding: 24px; border-radius: 10px; box-shadow: 0 3px 12px rgba(0,0,0,.08); }
        h1 { margin-top:0; color:#333; }
        .row { display:grid; grid-template-columns: 220px 1fr; gap:14px; margin-bottom:10px; }
        .label { font-weight:700; color:#555; }
        .value { color:#222; }
        .actions { margin-top:22px; display:flex; gap:10px; }
        .btn { padding:10px 14px; border:none; border-radius:6px; text-decoration:none; color:#fff; font-weight:600; }
        .btn-edit { background:#3498db; }
        .btn-back { background:#95a5a6; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detail Kuliner</h1>

        <div class="row"><div class="label">ID</div><div class="value">{{ $culinary->id_culinaries }}</div></div>
        <div class="row"><div class="label">Nama</div><div class="value">{{ $culinary->name }}</div></div>
        <div class="row"><div class="label">Alamat Tempat</div><div class="value">{{ $culinary->place_address }}</div></div>
        <div class="row"><div class="label">Kota/Kabupaten</div><div class="value">{{ $culinary->city }}</div></div>
        <div class="row"><div class="label">Provinsi</div><div class="value">{{ $culinary->province }}</div></div>
        <div class="row"><div class="label">Lokasi Gabungan</div><div class="value">{{ $culinary->location }}</div></div>
        <div class="row"><div class="label">Latitude</div><div class="value">{{ $culinary->latitude }}</div></div>
        <div class="row"><div class="label">Longitude</div><div class="value">{{ $culinary->longitude }}</div></div>
        <div class="row"><div class="label">Hari Operasional</div><div class="value">{{ $culinary->operational_days ?: '-' }}</div></div>
        <div class="row"><div class="label">Jam Operasional</div><div class="value">{{ $culinary->operational_hours ?: '-' }}</div></div>
        <div class="row"><div class="label">Transport</div><div class="value">{{ !empty($culinary->transport_modes) ? implode(', ', $culinary->transport_modes) : '-' }}</div></div>
        <div class="row"><div class="label">Harga</div><div class="value">{{ $culinary->price }}</div></div>
        <div class="row"><div class="label">Rating</div><div class="value">{{ $culinary->rating }}</div></div>
        <div class="row"><div class="label">Jenis Kuliner</div><div class="value">{{ $culinary->cuisine_type }}</div></div>
        <div class="row"><div class="label">Fasilitas</div><div class="value">{{ $culinary->amenities ?: '-' }}</div></div>
        <div class="row"><div class="label">Deskripsi</div><div class="value">{{ $culinary->description }}</div></div>
        <div class="row"><div class="label">Image Path</div><div class="value">{{ $culinary->image_url }}</div></div>
        <div class="row"><div class="label">Foto</div><div class="value">
            @if(!empty($culinary->image_url))
                <img src="{{ asset('storage/' . $culinary->image_url) }}" alt="Foto Kuliner" style="max-width:260px; border-radius:8px;">
            @else
                -
            @endif
        </div></div>
        <div class="row"><div class="label">Status Lokasi</div><div class="value">{{ $culinary->status_lokasi }}</div></div>
        <div class="row"><div class="label">Created At</div><div class="value">{{ $culinary->created_at }}</div></div>
        <div class="row"><div class="label">Updated At</div><div class="value">{{ $culinary->updated_at }}</div></div>

        <div class="actions">
            <a class="btn btn-edit" href="{{ route('admin.culinaries.edit', $culinary) }}">Edit</a>
            <a class="btn btn-back" href="{{ route('admin.dashboard') }}">Kembali</a>
        </div>
    </div>
</body>
</html>
