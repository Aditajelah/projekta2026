<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEdit ? 'Edit Penginapan' : 'Tambah Penginapan' }}</title>
    <style>
        :root {
            --bg-start: #f7f4ef;
            --bg-end: #eef5ff;
            --card: rgba(255, 255, 255, 0.9);
            --border: rgba(15, 23, 42, 0.08);
            --text: #102033;
            --muted: #607086;
            --primary: #0ea5e9;
            --success: #15803d;
            --danger: #b42318;
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--bg-start), var(--bg-end));
            margin: 0;
            color: var(--text);
        }
        .page-shell { max-width: 1100px; margin: 28px auto; padding: 0 18px 28px; }
        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(300px, 0.9fr);
            gap: 18px;
            align-items: stretch;
            margin-bottom: 18px;
        }
        .hero-card, .form-card, .photo-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 24px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(14px);
        }
        .hero-card { padding: 26px; }
        .eyebrow { display:inline-flex; margin:0 0 14px; padding:7px 12px; border-radius:999px; background:rgba(14,165,233,.08); color:var(--primary); font-size:12px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; }
        h1 { margin:0; font-size:34px; line-height:1.15; }
        .subtitle { margin:12px 0 0; color:var(--muted); line-height:1.6; max-width:60ch; }
        .meta-row { display:flex; flex-wrap:wrap; gap:10px; margin-top:18px; }
        .meta-pill { padding:9px 12px; border-radius:999px; background:rgba(15,23,42,.05); color:var(--text); font-size:13px; font-weight:600; }
        .photo-card { overflow:hidden; }
        .photo-card .photo-head { display:flex; justify-content:space-between; align-items:center; padding:18px 18px 0; color:var(--muted); font-size:13px; font-weight:600; }
        .photo-preview { width:100%; height:290px; object-fit:cover; display:block; margin-top:14px; }
        .photo-placeholder { min-height:290px; display:flex; align-items:center; justify-content:center; padding:24px; text-align:center; color:var(--muted); background:linear-gradient(135deg, rgba(14,165,233,.08), rgba(29,78,216,.08)); }
        .photo-note { margin:0; padding:14px 18px 18px; color:var(--muted); font-size:13px; }
        .form-card { padding: 24px; }
        .section-title { margin: 0 0 4px; font-size: 18px; }
        .section-subtitle { margin: 0 0 18px; color: var(--muted); font-size: 14px; }
        .grid { display:grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap:16px; }
        .full { grid-column: 1 / -1; }
        label { display:block; font-weight:700; margin-bottom:8px; color: var(--text); }
        input, textarea, select { width:100%; padding:12px 14px; border:1px solid #d8e0ea; border-radius:14px; background:#fff; color: var(--text); transition: border-color .2s ease, box-shadow .2s ease; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: rgba(14,165,233,0.5); box-shadow: 0 0 0 4px rgba(14,165,233,0.08); }
        textarea { min-height:130px; resize: vertical; }
        .field-card { padding: 16px; border: 1px solid #e5ebf2; border-radius: 18px; background: rgba(255, 255, 255, 0.74); }
        .actions { margin-top:24px; display:flex; gap:12px; flex-wrap:wrap; }
        .btn { padding:12px 16px; border:none; border-radius:12px; cursor:pointer; text-decoration:none; font-weight:700; }
        .btn-save { background: linear-gradient(135deg, var(--success), #22c55e); color:#fff; }
        .btn-back { background:#e2e8f0; color: var(--text); }
        .errors { background:#fff1f2; color:var(--danger); border:1px solid #fecdd3; padding:14px 16px; border-radius:14px; margin-bottom:16px; }
        .errors ul { margin:0; padding-left:18px; }
        .checkbox-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap:10px 14px; }
        .checkbox-grid label { display:flex; align-items:center; gap:8px; font-weight:600; margin:0; }
        .checkbox-grid input { width:auto; }
        .helper-text { margin-top: 8px; color: var(--muted); font-size: 13px; }
        @media (max-width: 860px) {
            .hero, .grid { grid-template-columns: 1fr; }
            .hero-card { order: 1; }
            .photo-card { order: -1; }
        }
    </style>
</head>
<body>
    @php
        $stayImage = !empty($stay->image_url) ? asset('storage/' . $stay->image_url) : null;
    @endphp
    <div class="page-shell">
        <div class="hero">
            <div class="hero-card">
                <p class="eyebrow">Admin Tempat</p>
                <h1>{{ $isEdit ? 'Edit Penginapan' : 'Tambah Penginapan' }}</h1>
                <p class="subtitle">Kelola data penginapan dengan tata letak yang lebih modern, lengkap dengan kartu foto utama di bagian atas.</p>
                <div class="meta-row">
                    <span class="meta-pill">Penginapan</span>
                    <span class="meta-pill">Amenities & harga</span>
                    <span class="meta-pill">Foto utama di atas</span>
                </div>
            </div>
            <div class="photo-card">
                <div class="photo-head">
                    <span>Foto utama penginapan</span>
                    <span>{{ $isEdit ? 'Preview saat ini' : 'Belum diunggah' }}</span>
                </div>
                @if($stayImage)
                    <img src="{{ $stayImage }}" alt="Foto Penginapan" class="photo-preview">
                    <p class="photo-note">Foto aktif yang tersimpan saat ini.</p>
                @else
                    <div class="photo-placeholder">Belum ada foto penginapan. Upload gambar agar detail lebih menarik.</div>
                @endif
            </div>
        </div>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $isEdit ? route('admin.stays.update', $stay) : route('admin.stays.store') }}" enctype="multipart/form-data">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="form-card">
                <h2 class="section-title">Detail penginapan</h2>
                <p class="section-subtitle">Isi data lokasi, fasilitas, jadwal, dan foto pendukung pada satu halaman yang lebih terstruktur.</p>
                <div class="grid">
                <div class="field-card">
                    <label>Nama</label>
                    <input type="text" name="name" value="{{ old('name', $stay->name) }}" required>
                </div>
                <div class="field-card">
                    <label>Alamat Tempat</label>
                    <input type="text" name="place_address" value="{{ old('place_address', $stay->place_address) }}" required>
                </div>
                <div class="field-card">
                    <label>Kota/Kabupaten</label>
                    <input type="text" name="city" placeholder="Contoh: Kota Bandung / Kabupaten Sleman" value="{{ old('city', $stay->city) }}" required>
                </div>
                <div class="field-card">
                    <label>Provinsi</label>
                    <input type="text" name="province" value="{{ old('province', $stay->province) }}" required>
                </div>
                <div class="field-card">
                    <label>Latitude</label>
                    <input type="number" step="0.0000001" name="latitude" value="{{ old('latitude', $stay->latitude) }}">
                </div>
                <div class="field-card">
                    <label>Longitude</label>
                    <input type="number" step="0.0000001" name="longitude" value="{{ old('longitude', $stay->longitude) }}">
                </div>
                @include('admin.partials.operational-schedule-form', ['model' => $stay, 'idPrefix' => 'stay'])
                <div class="field-card">
                    @php
                        $currentPrice = old('price', $stay->price);
                        $selectedPriceOption = old('price_option', ((float) $currentPrice) <= 0 ? 'gratis' : 'berbayar');
                        $priceCustomValue = old('price_custom', ((float) $currentPrice) > 0 ? $currentPrice : '');
                    @endphp
                    <label>Harga</label>
                    <select name="price_option" id="price_option_stay" required>
                        <option value="gratis" {{ $selectedPriceOption === 'gratis' ? 'selected' : '' }}>Gratis</option>
                        <option value="berbayar" {{ $selectedPriceOption === 'berbayar' ? 'selected' : '' }}>Berbayar</option>
                    </select>
                    <input id="price_custom_stay" type="number" step="0.01" min="0" name="price_custom" placeholder="Masukkan harga" value="{{ $priceCustomValue }}" style="margin-top:8px; display:none;">
                </div>
                <div class="field-card full">
                    <label>Foto (Upload)</label>
                    <input type="file" name="image_file" accept="image/*">
                    <div class="helper-text">Upload foto baru jika ingin mengganti gambar utama penginapan.</div>
                </div>
                <div class="field-card full">
                    <label>Transport ke Lokasi</label>
                    @php
                        $selectedTransport = old('transport_modes', $stay->transport_modes ?? []);
                    @endphp
                    <div class="checkbox-grid">
                        <label><input type="checkbox" name="transport_modes[]" value="mobil" {{ in_array('mobil', $selectedTransport ?? []) ? 'checked' : '' }}> Mobil</label>
                        <label><input type="checkbox" name="transport_modes[]" value="motor" {{ in_array('motor', $selectedTransport ?? []) ? 'checked' : '' }}> Motor</label>
                        <label><input type="checkbox" name="transport_modes[]" value="jalan kaki" {{ in_array('jalan kaki', $selectedTransport ?? []) ? 'checked' : '' }}> Jalan Kaki</label>
                        <label><input type="checkbox" name="transport_modes[]" value="bus" {{ in_array('bus', $selectedTransport ?? []) ? 'checked' : '' }}> Bus</label>
                        <label><input type="checkbox" name="transport_modes[]" value="kapal" {{ in_array('kapal', $selectedTransport ?? []) ? 'checked' : '' }}> Kapal</label>
                    </div>
                </div>
                <div class="field-card full">
                    <label>Status Lokasi</label>
                    <select name="status_lokasi" required>
                        <option value="terkenal" {{ old('status_lokasi', $stay->status_lokasi) === 'terkenal' ? 'selected' : '' }}>terkenal</option>
                        <option value="hidden gem" {{ old('status_lokasi', $stay->status_lokasi) === 'hidden gem' ? 'selected' : '' }}>hidden gem</option>
                    </select>
                </div>
                <div class="field-card full">
                    <label>Amenities</label>
                    @php
                        $amenityOptions = [
                            'wifi' => 'WiFi',
                            'ac' => 'AC',
                            'parkir' => 'Parkir',
                            'sarapan' => 'Sarapan',
                            'restoran' => 'Restoran',
                            'kolam renang' => 'Kolam Renang',
                            'air panas' => 'Air Panas',
                            'tv' => 'TV',
                            'kamar mandi dalam' => 'Kamar Mandi Dalam',
                            'resepsionis 24 jam' => 'Resepsionis 24 Jam',
                        ];
                        $selectedAmenities = old('amenities');
                        if (!is_array($selectedAmenities)) {
                            $selectedAmenities = array_values(array_filter(array_map('trim', explode(',', (string) ($stay->amenities ?? '')))));
                        }
                    @endphp
                    <div class="checkbox-grid">
                        @foreach($amenityOptions as $value => $label)
                            <label>
                                <input type="checkbox" name="amenities[]" value="{{ $value }}" {{ in_array($value, $selectedAmenities ?? []) ? 'checked' : '' }}>
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="field-card full">
                    <label>Deskripsi</label>
                    <textarea name="description">{{ old('description', $stay->description) }}</textarea>
                </div>
                </div>

            <div class="actions">
                <button class="btn btn-save" type="submit">Simpan</button>
                <a class="btn btn-back" href="{{ route('admin.dashboard') }}">Kembali</a>
            </div>
        </form>
    </div>
    <script>
        (function () {
            const priceOption = document.getElementById('price_option_stay');
            const priceCustom = document.getElementById('price_custom_stay');

            function refreshVisibility() {
                toggleField(priceOption, priceCustom, 'berbayar');
            }

            function toggleField(selectEl, inputEl, expectedValue) {
                if (!selectEl || !inputEl) {
                    return;
                }
                inputEl.style.display = selectEl.value === expectedValue ? 'block' : 'none';
            }
            priceOption?.addEventListener('change', refreshVisibility);
            refreshVisibility();
        })();
    </script>
</body>
</html>
