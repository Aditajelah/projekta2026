@php
    $days = [
        'senin' => 'Senin',
        'selasa' => 'Selasa',
        'rabu' => 'Rabu',
        'kamis' => 'Kamis',
        'jumat' => 'Jumat',
        'sabtu' => 'Sabtu',
        'minggu' => 'Minggu',
    ];

    $currentSchedule = old('operational_schedule', $model->operational_schedule ?? []);

    if (!is_array($currentSchedule)) {
        $currentSchedule = [];
    }
@endphp

<div class="full">
    <label>Jadwal Operasional</label>
    <div style="margin:8px 0 12px; font-size:12px; color:#666; line-height:1.45;">
        Pilih status <strong>Buka</strong>, <strong>24 Jam</strong>, atau <strong>Libur</strong> untuk tiap hari. Kalau buka, isi jam mulai dan selesai.
    </div>

    <div style="overflow-x:auto; border:1px solid #e5e7eb; border-radius:8px;">
        <table style="width:100%; border-collapse:collapse; min-width:720px;">
            <thead style="background:#f9fafb;">
                <tr>
                    <th style="padding:12px; text-align:left; border-bottom:1px solid #e5e7eb;">Hari</th>
                    <th style="padding:12px; text-align:left; border-bottom:1px solid #e5e7eb;">Status</th>
                    <th style="padding:12px; text-align:left; border-bottom:1px solid #e5e7eb;">Jam Buka</th>
                    <th style="padding:12px; text-align:left; border-bottom:1px solid #e5e7eb;">Jam Tutup</th>
                </tr>
            </thead>
            <tbody>
                @foreach($days as $dayKey => $dayLabel)
                    @php
                        $currentDay = $currentSchedule[$dayKey] ?? [];
                        $status = $currentDay['status'] ?? 'closed';
                        $openTime = $currentDay['open_time'] ?? '';
                        $closeTime = $currentDay['close_time'] ?? '';
                    @endphp
                    <tr data-schedule-row>
                        <td style="padding:12px; border-bottom:1px solid #e5e7eb; font-weight:600;">{{ $dayLabel }}</td>
                        <td style="padding:12px; border-bottom:1px solid #e5e7eb; min-width:160px;">
                            <select name="operational_schedule[{{ $dayKey }}][status]" data-schedule-status>
                                <option value="open" {{ $status === 'open' ? 'selected' : '' }}>Buka</option>
                                <option value="full_day" {{ $status === 'full_day' ? 'selected' : '' }}>24 Jam</option>
                                <option value="closed" {{ $status === 'closed' ? 'selected' : '' }}>Libur</option>
                            </select>
                        </td>
                        <td style="padding:12px; border-bottom:1px solid #e5e7eb; min-width:160px;">
                            <input type="time" name="operational_schedule[{{ $dayKey }}][open_time]" value="{{ $openTime }}" data-schedule-time>
                        </td>
                        <td style="padding:12px; border-bottom:1px solid #e5e7eb; min-width:160px;">
                            <input type="time" name="operational_schedule[{{ $dayKey }}][close_time]" value="{{ $closeTime }}" data-schedule-time>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    (function () {
        const rows = document.querySelectorAll('[data-schedule-row]');

        rows.forEach(function (row) {
            const statusSelect = row.querySelector('[data-schedule-status]');
            const timeInputs = row.querySelectorAll('[data-schedule-time]');

            function refreshRow() {
                const isOpen = statusSelect.value === 'open';
                const isFullDay = statusSelect.value === 'full_day';

                timeInputs.forEach(function (input) {
                    input.disabled = !isOpen;
                    input.style.opacity = isOpen ? '1' : '0.5';
                    if (isFullDay && input.name.endsWith('[open_time]')) {
                        input.value = '00:00';
                    }
                    if (isFullDay && input.name.endsWith('[close_time]')) {
                        input.value = '23:59';
                    }
                });
            }

            statusSelect.addEventListener('change', refreshRow);
            refreshRow();
        });
    })();
</script>