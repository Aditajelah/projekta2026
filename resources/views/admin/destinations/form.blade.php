<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEdit ? 'Edit Destinasi' : 'Tambah Destinasi' }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background:#f5f5f5; margin:0; }
        .container { max-width: 900px; margin: 30px auto; background:#fff; padding: 24px; border-radius: 10px; box-shadow: 0 3px 12px rgba(0,0,0,.08); }
        h1 { margin-top:0; color:#333; }
        .grid { display:grid; grid-template-columns: 1fr 1fr; gap:16px; }
        .full { grid-column: 1 / -1; }
        label { display:block; font-weight:600; margin-bottom:6px; color:#444; }
        input, textarea, select { width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; }
        textarea { min-height:120px; }
        .actions { margin-top:20px; display:flex; gap:10px; }
        .btn { padding:10px 14px; border:none; border-radius:6px; cursor:pointer; text-decoration:none; font-weight:600; }
        .btn-save { background:#27ae60; color:#fff; }
        .btn-back { background:#95a5a6; color:#fff; }
        .errors { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; padding:12px; border-radius:6px; margin-bottom:16px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $isEdit ? 'Edit Destinasi' : 'Tambah Destinasi' }}</h1>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $isEdit ? route('admin.destinations.update', $destination) : route('admin.destinations.store') }}" enctype="multipart/form-data">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid">
                <div>
                    <label>Nama</label>
                    <input type="text" name="name" value="{{ old('name', $destination->name) }}" required>
                </div>
                <div>
                    <label>Alamat Tempat</label>
                    <input type="text" name="place_address" value="{{ old('place_address', $destination->place_address) }}" required>
                </div>
                <div>
                    <label>Kota/Kabupaten</label>
                    <input type="text" name="city" placeholder="Contoh: Kota Bandung / Kabupaten Sleman" value="{{ old('city', $destination->city) }}" required>
                </div>
                <div>
                    <label>Provinsi</label>
                    <input type="text" name="province" value="{{ old('province', $destination->province) }}" required>
                </div>
                <div>
                    <label>Latitude</label>
                    <input type="number" step="0.0000001" name="latitude" value="{{ old('latitude', $destination->latitude) }}">
                </div>
                <div>
                    <label>Longitude</label>
                    <input type="number" step="0.0000001" name="longitude" value="{{ old('longitude', $destination->longitude) }}">
                </div>
                <div>
                    @php
                        $currentOperationalDays = old('operational_days', $destination->operational_days);
                        $selectedDaysOption = old('operational_days_option', $currentOperationalDays === 'setiap hari' ? 'setiap hari' : (!empty($currentOperationalDays) ? 'hari tertentu' : ''));
                        $daysCustomValue = old('operational_days_custom', $selectedDaysOption === 'hari tertentu' ? $currentOperationalDays : '');
                    @endphp
                    <label>Hari Operasional</label>
                    <select name="operational_days_option" id="days_option_destination">
                        <option value="">-- Pilih --</option>
                        <option value="setiap hari" {{ $selectedDaysOption === 'setiap hari' ? 'selected' : '' }}>Setiap Hari</option>
                        <option value="hari tertentu" {{ $selectedDaysOption === 'hari tertentu' ? 'selected' : '' }}>Hari Tertentu</option>
                    </select>
                    <input id="days_custom_destination" type="text" name="operational_days_custom" placeholder="Contoh: Senin - Jumat" value="{{ $daysCustomValue }}" style="margin-top:8px; display:none;">
                </div>
                <div>
                    @php
                        $currentOperationalHours = old('operational_hours', $destination->operational_hours);
                        $selectedHoursOption = old('operational_hours_option', $currentOperationalHours === '24 jam' ? '24 jam' : (!empty($currentOperationalHours) ? 'jam tertentu' : ''));
                        $hoursCustomValue = old('operational_hours_custom', $selectedHoursOption === 'jam tertentu' ? $currentOperationalHours : '');
                    @endphp
                    <label>Jam Operasional</label>
                    <select name="operational_hours_option" id="hours_option_destination">
                        <option value="">-- Pilih --</option>
                        <option value="24 jam" {{ $selectedHoursOption === '24 jam' ? 'selected' : '' }}>24 Jam</option>
                        <option value="jam tertentu" {{ $selectedHoursOption === 'jam tertentu' ? 'selected' : '' }}>Jam Tertentu</option>
                    </select>
                    <input id="hours_custom_destination" type="text" name="operational_hours_custom" placeholder="Contoh: 08:00 - 17:00" value="{{ $hoursCustomValue }}" style="margin-top:8px; display:none;">
                </div>
                <div>
                    @php
                        $currentPrice = old('price', $destination->price);
                        $selectedPriceOption = old('price_option', ((float) $currentPrice) <= 0 ? 'gratis' : 'berbayar');
                        $priceCustomValue = old('price_custom', ((float) $currentPrice) > 0 ? $currentPrice : '');
                    @endphp
                    <label>Harga</label>
                    <select name="price_option" id="price_option_destination" required>
                        <option value="gratis" {{ $selectedPriceOption === 'gratis' ? 'selected' : '' }}>Gratis</option>
                        <option value="berbayar" {{ $selectedPriceOption === 'berbayar' ? 'selected' : '' }}>Berbayar</option>
                    </select>
                    <input id="price_custom_destination" type="number" step="0.01" min="0" name="price_custom" placeholder="Masukkan harga" value="{{ $priceCustomValue }}" style="margin-top:8px; display:none;">
                </div>
                <div>
                    <label>Kategori</label>
                    @php
                        $categoryOptions = [
                            'tempat prasejarah',
                            'wisata alam',
                            'wisata sejarah',
                            'wisata budaya',
                            'wisata religi',
                            'wisata edukasi',
                            'wisata bahari',
                            'wisata buatan',
                            'agrowisata',
                            'desa wisata',
                            'taman hiburan',
                            'lainnya',
                        ];
                        $selectedCategory = old('category', $destination->category);
                    @endphp
                    <select name="category" required>
                        <option value="" disabled {{ empty($selectedCategory) ? 'selected' : '' }}>Pilih kategori wisata</option>
                        @foreach($categoryOptions as $option)
                            <option value="{{ $option }}" {{ $selectedCategory === $option ? 'selected' : '' }}>{{ ucwords($option) }}</option>
                        @endforeach
                        @if(!empty($selectedCategory) && !in_array($selectedCategory, $categoryOptions))
                            <option value="{{ $selectedCategory }}" selected>{{ $selectedCategory }}</option>
                        @endif
                    </select>
                </div>
                <div>
                    <label>Foto (Upload)</label>
                    <input type="file" name="image_file" accept="image/*">
                    @if(!empty($destination->image_url))
                        <div style="margin-top:8px; font-size:12px; color:#555;">Foto saat ini:</div>
                        <img src="{{ asset('storage/' . $destination->image_url) }}" alt="Foto Destinasi" style="max-width:220px; margin-top:6px; border-radius:6px;">
                    @endif
                </div>
                <div class="full">
                    <label>Transport ke Lokasi</label>
                    @php
                        $selectedTransport = old('transport_modes', $destination->transport_modes ?? []);
                    @endphp
                    <div style="display:flex; gap:16px; flex-wrap:wrap;">
                        <label style="font-weight:500;"><input type="checkbox" name="transport_modes[]" value="mobil" {{ in_array('mobil', $selectedTransport ?? []) ? 'checked' : '' }}> Mobil</label>
                        <label style="font-weight:500;"><input type="checkbox" name="transport_modes[]" value="motor" {{ in_array('motor', $selectedTransport ?? []) ? 'checked' : '' }}> Motor</label>
                        <label style="font-weight:500;"><input type="checkbox" name="transport_modes[]" value="jalan kaki" {{ in_array('jalan kaki', $selectedTransport ?? []) ? 'checked' : '' }}> Jalan Kaki</label>
                        <label style="font-weight:500;"><input type="checkbox" name="transport_modes[]" value="bus" {{ in_array('bus', $selectedTransport ?? []) ? 'checked' : '' }}> Bus</label>
                        <label style="font-weight:500;"><input type="checkbox" name="transport_modes[]" value="kapal" {{ in_array('kapal', $selectedTransport ?? []) ? 'checked' : '' }}> Kapal</label>
                    </div>
                </div>
                <div class="full">
                    <label>Status Lokasi</label>
                    <select name="status_lokasi" required>
                        <option value="terkenal" {{ old('status_lokasi', $destination->status_lokasi) === 'terkenal' ? 'selected' : '' }}>terkenal</option>
                        <option value="hidden gem" {{ old('status_lokasi', $destination->status_lokasi) === 'hidden gem' ? 'selected' : '' }}>hidden gem</option>
                    </select>
                </div>
                <div class="full">
                    <label>Deskripsi</label>
                    <textarea name="description">{{ old('description', $destination->description) }}</textarea>
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
            const daysOption = document.getElementById('days_option_destination');
            const daysCustom = document.getElementById('days_custom_destination');
            const hoursOption = document.getElementById('hours_option_destination');
            const hoursCustom = document.getElementById('hours_custom_destination');
            const priceOption = document.getElementById('price_option_destination');
            const priceCustom = document.getElementById('price_custom_destination');

            function toggleField(selectEl, inputEl, expectedValue) {
                if (!selectEl || !inputEl) {
                    return;
                }
                inputEl.style.display = selectEl.value === expectedValue ? 'block' : 'none';
            }

            function refreshVisibility() {
                toggleField(daysOption, daysCustom, 'hari tertentu');
                toggleField(hoursOption, hoursCustom, 'jam tertentu');
                toggleField(priceOption, priceCustom, 'berbayar');
            }

            daysOption?.addEventListener('change', refreshVisibility);
            hoursOption?.addEventListener('change', refreshVisibility);
            priceOption?.addEventListener('change', refreshVisibility);
            refreshVisibility();
        })();
    </script>
</body>
</html>
