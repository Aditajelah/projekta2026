<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Destinasi</title>
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
        <h1>Detail Destinasi</h1>

        <div class="row"><div class="label">ID</div><div class="value">{{ $destination->id_destinations }}</div></div>
        <div class="row"><div class="label">Nama</div><div class="value">{{ $destination->name }}</div></div>
        <div class="row"><div class="label">Alamat Tempat</div><div class="value">{{ $destination->place_address }}</div></div>
        <div class="row"><div class="label">Kota/Kabupaten</div><div class="value">{{ $destination->city }}</div></div>
        <div class="row"><div class="label">Provinsi</div><div class="value">{{ $destination->province }}</div></div>
        <div class="row"><div class="label">Lokasi Gabungan</div><div class="value">{{ $destination->location }}</div></div>
        <div class="row"><div class="label">Latitude</div><div class="value">{{ $destination->latitude }}</div></div>
        <div class="row"><div class="label">Longitude</div><div class="value">{{ $destination->longitude }}</div></div>
        <div class="row"><div class="label">Hari Operasional</div><div class="value">{{ $destination->operational_days ?: '-' }}</div></div>
        <div class="row"><div class="label">Jam Operasional</div><div class="value">{{ $destination->operational_hours ?: '-' }}</div></div>
        <div class="row"><div class="label">Transport</div><div class="value">{{ !empty($destination->transport_modes) ? implode(', ', $destination->transport_modes) : '-' }}</div></div>
        <div class="row"><div class="label">Harga</div><div class="value">{{ $destination->price }}</div></div>
        <div class="row"><div class="label">Rating</div><div class="value">{{ $destination->rating }}</div></div>
        <div class="row"><div class="label">Kategori</div><div class="value">{{ $destination->category }}</div></div>
        <div class="row"><div class="label">Deskripsi</div><div class="value">{{ $destination->description }}</div></div>
        <div class="row"><div class="label">Image Path</div><div class="value">{{ $destination->image_url }}</div></div>
        <div class="row"><div class="label">Foto</div><div class="value">
            @if(!empty($destination->image_url))
                <img src="{{ asset('storage/' . $destination->image_url) }}" alt="Foto Destinasi" style="max-width:260px; border-radius:8px;">
            @else
                -
            @endif
        </div></div>
        <div class="row"><div class="label">Status Lokasi</div><div class="value">{{ $destination->status_lokasi }}</div></div>
        <div class="row"><div class="label">Created At</div><div class="value">{{ $destination->created_at }}</div></div>
        <div class="row"><div class="label">Updated At</div><div class="value">{{ $destination->updated_at }}</div></div>

        <div class="actions">
            <a class="btn btn-edit" href="{{ route('admin.destinations.edit', $destination) }}">Edit</a>
            <a class="btn btn-back" href="{{ route('admin.dashboard') }}">Kembali</a>
        </div>
    </div>
</body>
</html>
