<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEdit ? 'Edit Kuliner' : 'Tambah Kuliner' }}</title>
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
        .checkbox-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:8px 14px; }
        .checkbox-grid label { display:flex; align-items:center; gap:8px; font-weight:500; margin:0; }
        .checkbox-grid input { width:auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $isEdit ? 'Edit Kuliner' : 'Tambah Kuliner' }}</h1>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $isEdit ? route('admin.culinaries.update', $culinary) : route('admin.culinaries.store') }}" enctype="multipart/form-data">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid">
                <div>
                    <label>Nama</label>
                    <input type="text" name="name" value="{{ old('name', $culinary->name) }}" required>
                </div>
                <div>
                    <label>Alamat Tempat</label>
                    <input type="text" name="place_address" value="{{ old('place_address', $culinary->place_address) }}" required>
                </div>
                <div>
                    <label>Kota/Kabupaten</label>
                    <input type="text" name="city" placeholder="Contoh: Kota Bandung / Kabupaten Sleman" value="{{ old('city', $culinary->city) }}" required>
                </div>
                <div>
                    <label>Provinsi</label>
                    <input type="text" name="province" value="{{ old('province', $culinary->province) }}" required>
                </div>
                <div>
                    <label>Latitude</label>
                    <input type="number" step="0.0000001" name="latitude" value="{{ old('latitude', $culinary->latitude) }}">
                </div>
                <div>
                    <label>Longitude</label>
                    <input type="number" step="0.0000001" name="longitude" value="{{ old('longitude', $culinary->longitude) }}">
                </div>
                <div>
                    @php
                        $currentOperationalDays = old('operational_days', $culinary->operational_days);
                        $selectedDaysOption = old('operational_days_option', $currentOperationalDays === 'setiap hari' ? 'setiap hari' : (!empty($currentOperationalDays) ? 'hari tertentu' : ''));
                        $daysCustomValue = old('operational_days_custom', $selectedDaysOption === 'hari tertentu' ? $currentOperationalDays : '');
                    @endphp
                    <label>Hari Operasional</label>
                    <select name="operational_days_option" id="days_option_culinary">
                        <option value="">-- Pilih --</option>
                        <option value="setiap hari" {{ $selectedDaysOption === 'setiap hari' ? 'selected' : '' }}>Setiap Hari</option>
                        <option value="hari tertentu" {{ $selectedDaysOption === 'hari tertentu' ? 'selected' : '' }}>Hari Tertentu</option>
                    </select>
                    <input id="days_custom_culinary" type="text" name="operational_days_custom" placeholder="Contoh: Senin - Jumat" value="{{ $daysCustomValue }}" style="margin-top:8px; display:none;">
                </div>
                <div>
                    @php
                        $currentOperationalHours = old('operational_hours', $culinary->operational_hours);
                        $selectedHoursOption = old('operational_hours_option', $currentOperationalHours === '24 jam' ? '24 jam' : (!empty($currentOperationalHours) ? 'jam tertentu' : ''));
                        $hoursCustomValue = old('operational_hours_custom', $selectedHoursOption === 'jam tertentu' ? $currentOperationalHours : '');
                    @endphp
                    <label>Jam Operasional</label>
                    <select name="operational_hours_option" id="hours_option_culinary">
                        <option value="">-- Pilih --</option>
                        <option value="24 jam" {{ $selectedHoursOption === '24 jam' ? 'selected' : '' }}>24 Jam</option>
                        <option value="jam tertentu" {{ $selectedHoursOption === 'jam tertentu' ? 'selected' : '' }}>Jam Tertentu</option>
                    </select>
                    <input id="hours_custom_culinary" type="text" name="operational_hours_custom" placeholder="Contoh: 08:00 - 22:00" value="{{ $hoursCustomValue }}" style="margin-top:8px; display:none;">
                </div>
                <div>
                    <label>Kategori Makanan</label>
                    @php
                        $selectedCuisineType = old('cuisine_type', $culinary->cuisine_type);
                    @endphp
                    <select name="cuisine_type" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="makanan tradisional" {{ $selectedCuisineType === 'makanan tradisional' ? 'selected' : '' }}>Makanan Tradisional</option>
                        <option value="makanan khas daerah" {{ $selectedCuisineType === 'makanan khas daerah' ? 'selected' : '' }}>Makanan Khas Daerah</option>
                        <option value="makanan ringan" {{ $selectedCuisineType === 'makanan ringan' ? 'selected' : '' }}>Makanan Ringan</option>
                        <option value="jajanan kaki lima" {{ $selectedCuisineType === 'jajanan kaki lima' ? 'selected' : '' }}>Jajanan Kaki Lima</option>
                        <option value="makanan laut" {{ $selectedCuisineType === 'makanan laut' ? 'selected' : '' }}>Makanan Laut</option>
                        <option value="makanan cepat saji" {{ $selectedCuisineType === 'makanan cepat saji' ? 'selected' : '' }}>Makanan Cepat Saji</option>
                        <option value="makanan penutup" {{ $selectedCuisineType === 'makanan penutup' ? 'selected' : '' }}>Makanan Penutup</option>
                        <option value="minuman" {{ $selectedCuisineType === 'minuman' ? 'selected' : '' }}>Minuman</option>
                    </select>
                </div>
                <div>
                    @php
                        $currentPrice = old('price', $culinary->price);
                        $selectedPriceOption = old('price_option', ((float) $currentPrice) <= 0 ? 'gratis' : 'berbayar');
                        $priceCustomValue = old('price_custom', ((float) $currentPrice) > 0 ? $currentPrice : '');
                    @endphp
                    <label>Harga</label>
                    <select name="price_option" id="price_option_culinary" required>
                        <option value="gratis" {{ $selectedPriceOption === 'gratis' ? 'selected' : '' }}>Gratis</option>
                        <option value="berbayar" {{ $selectedPriceOption === 'berbayar' ? 'selected' : '' }}>Berbayar</option>
                    </select>
                    <input id="price_custom_culinary" type="number" step="0.01" min="0" name="price_custom" placeholder="Masukkan harga" value="{{ $priceCustomValue }}" style="margin-top:8px; display:none;">
                </div>
                <div class="full">
                    <label>Foto (Upload)</label>
                    <input type="file" name="image_file" accept="image/*">
                    @if(!empty($culinary->image_url))
                        <div style="margin-top:8px; font-size:12px; color:#555;">Foto saat ini:</div>
                        <img src="{{ asset('storage/' . $culinary->image_url) }}" alt="Foto Kuliner" style="max-width:220px; margin-top:6px; border-radius:6px;">
                    @endif
                </div>
                <div class="full">
                    <label>Transport ke Lokasi</label>
                    @php
                        $selectedTransport = old('transport_modes', $culinary->transport_modes ?? []);
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
                        <option value="terkenal" {{ old('status_lokasi', $culinary->status_lokasi) === 'terkenal' ? 'selected' : '' }}>terkenal</option>
                        <option value="hidden gem" {{ old('status_lokasi', $culinary->status_lokasi) === 'hidden gem' ? 'selected' : '' }}>hidden gem</option>
                    </select>
                </div>
                <div class="full">
                    <label>Fasilitas</label>
                    @php
                        $amenityOptions = [
                            'free wifi' => 'Free WiFi',
                            'free parking' => 'Free Parking',
                            'toilet' => 'Toilet',
                            'mushola' => 'Mushola',
                            'ruang keluarga' => 'Ruang Keluarga',
                            'live music' => 'Live Music',
                            'reservasi' => 'Reservasi',
                            'pembayaran tunai' => 'Pembayaran Tunai',
                            'pembayaran non tunai' => 'Pembayaran Non Tunai',
                            'takeaway' => 'Takeaway',
                        ];
                        $selectedAmenities = old('amenities');
                        if (!is_array($selectedAmenities)) {
                            $selectedAmenities = array_values(array_filter(array_map('trim', explode(',', (string) ($culinary->amenities ?? '')))));
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
                <div class="full">
                    <label>Deskripsi</label>
                    <textarea name="description" required>{{ old('description', $culinary->description) }}</textarea>
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
            const daysOption = document.getElementById('days_option_culinary');
            const daysCustom = document.getElementById('days_custom_culinary');
            const hoursOption = document.getElementById('hours_option_culinary');
            const hoursCustom = document.getElementById('hours_custom_culinary');
            const priceOption = document.getElementById('price_option_culinary');
            const priceCustom = document.getElementById('price_custom_culinary');

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
