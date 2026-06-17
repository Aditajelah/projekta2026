@php
    $schedule = $model->operational_schedule ?? [];
@endphp

@if(is_array($schedule) && count($schedule) > 0)
    <div style="display:grid; gap:10px;">
        @foreach($schedule as $row)
            <div style="padding:12px; border:1px solid #e5e7eb; border-radius:8px; background:#fafafa;">
                <div style="font-weight:700; margin-bottom:4px;">{{ $row['label'] ?? ucfirst($row['day'] ?? '-') }}</div>
                <div style="font-size:14px; color:#374151;">
                    @if(($row['status'] ?? 'closed') === 'full_day')
                        24 Jam
                    @elseif(($row['status'] ?? 'closed') === 'open')
                        Buka: {{ $row['open_time'] ?? '-' }} - {{ $row['close_time'] ?? '-' }}
                    @else
                        Libur
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="row"><div class="label">Hari Operasional</div><div class="value">{{ $model->operational_days ?: '-' }}</div></div>
    <div class="row"><div class="label">Jam Operasional</div><div class="value">{{ $model->operational_hours ?: '-' }}</div></div>
@endif