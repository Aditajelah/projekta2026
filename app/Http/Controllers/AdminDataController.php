<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Culinary;
use App\Models\Destination;
use App\Models\Rating;
use App\Models\Stay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminDataController extends Controller
{
    // Batas maksimum surat peringatan untuk moderasi komentar member.
    private const MAX_WARNING_COUNT = 3;

    // Daftar hari yang dipakai untuk normalisasi jadwal operasional mingguan.
    private const WEEK_DAYS = [
        'senin' => 'Senin',
        'selasa' => 'Selasa',
        'rabu' => 'Rabu',
        'kamis' => 'Kamis',
        'jumat' => 'Jumat',
        'sabtu' => 'Sabtu',
        'minggu' => 'Minggu',
    ];

    /**
     * Menampilkan daftar komentar member untuk kebutuhan moderasi admin.
     */
    public function comments()
    {
        $this->ensureAdmin();

        $comments = Rating::with(['user', 'rateable'])
            ->whereNotNull('review')
            ->where('review', '!=', '')
            ->latest()
            ->paginate(25);

        return view('admin.comments.index', [
            'comments' => $comments,
            'maxWarningCount' => self::MAX_WARNING_COUNT,
        ]);
    }

    /**
     * Menghapus komentar dan mencatat perubahan ke audit log.
     */
    public function destroyComment(Rating $comment)
    {
        $this->ensureAdmin();

        $before = $comment->toArray();
        $commentId = $comment->getKey();

        $comment->delete();

        $this->writeAuditLog('delete', 'comments', $commentId, $before, null);

        return redirect()
            ->route('admin.comments.index')
            ->with('success', 'Komentar berhasil dihapus.');
    }

    /**
     * Mengirim surat peringatan ke pemilik komentar yang melanggar.
     */
    public function sendWarning(Rating $comment)
    {
        $this->ensureAdmin();

        $user = $comment->user;

        if (!$user instanceof User) {
            return redirect()
                ->route('admin.comments.index')
                ->withErrors(['warning' => 'Member untuk komentar ini tidak ditemukan.']);
        }

        if ($user->warning_count >= self::MAX_WARNING_COUNT) {
            return redirect()
                ->route('admin.comments.index')
                ->withErrors(['warning' => 'Member sudah mencapai batas maksimal 3 surat peringatan.']);
        }

        $before = $user->toArray();
        $user->increment('warning_count');
        $user->refresh();

        $this->writeAuditLog('update', 'user_warnings', $user->getKey(), $before, $user->toArray());

        return redirect()
            ->route('admin.comments.index')
            ->with('success', 'Surat peringatan berhasil dikirim ke member. Total peringatan: ' . $user->warning_count . '/3.');
    }

    /**
     * Menampilkan histori audit perubahan data oleh admin.
     */
    public function logs()
    {
        $logs = AuditLog::with('user')->latest('changed_at')->paginate(25);

        return view('admin.logs.index', compact('logs'));
    }

    public function destinationShow(Destination $destination)
    {
        return view('admin.destinations.show', compact('destination'));
    }

    public function destinationCreate()
    {
        return view('admin.destinations.form', [
            'destination' => new Destination(),
            'isEdit' => false,
        ]);
    }

    public function destinationStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'place_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'operational_days_option' => 'nullable|in:setiap hari,hari tertentu',
            'operational_days_custom' => 'nullable|string|max:255|required_if:operational_days_option,hari tertentu',
            'operational_hours_option' => 'nullable|in:24 jam,jam tertentu',
            'operational_hours_custom' => 'nullable|string|max:255|required_if:operational_hours_option,jam tertentu',
            'operational_days' => 'nullable|string|max:255',
            'operational_hours' => 'nullable|string|max:255',
            'transport_modes' => 'nullable|array',
            'transport_modes.*' => 'in:mobil,motor,jalan kaki,bus,kapal',
            'price_option' => 'required|in:gratis,berbayar',
            'price_custom' => 'nullable|numeric|min:0|required_if:price_option,berbayar',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_lokasi' => ['required', Rule::in(['terkenal', 'hidden gem'])],
        ]);

        $validated = $this->applyOperationalSchedule($request, $validated);
        $validated = $this->applyPriceOption($request, $validated);
        $validated['transport_modes'] = $request->input('transport_modes', []);
        $validated['location'] = $validated['place_address'] . ', ' . $validated['city'] . ', ' . $validated['province'];
        $validated['image_url'] = $this->storeImage($request, null);

        $destination = Destination::create($validated);

        $this->writeAuditLog('create', 'destinations', $destination->getKey(), null, $destination->toArray());

        return redirect()->route('admin.dashboard')->with('success', 'Destinasi berhasil ditambahkan.');
    }

    public function destinationEdit(Destination $destination)
    {
        return view('admin.destinations.form', [
            'destination' => $destination,
            'isEdit' => true,
        ]);
    }

    public function destinationUpdate(Request $request, Destination $destination)
    {
        $before = $destination->toArray();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'place_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'operational_days_option' => 'nullable|in:setiap hari,hari tertentu',
            'operational_days_custom' => 'nullable|string|max:255|required_if:operational_days_option,hari tertentu',
            'operational_hours_option' => 'nullable|in:24 jam,jam tertentu',
            'operational_hours_custom' => 'nullable|string|max:255|required_if:operational_hours_option,jam tertentu',
            'operational_days' => 'nullable|string|max:255',
            'operational_hours' => 'nullable|string|max:255',
            'transport_modes' => 'nullable|array',
            'transport_modes.*' => 'in:mobil,motor,jalan kaki,bus,kapal',
            'price_option' => 'required|in:gratis,berbayar',
            'price_custom' => 'nullable|numeric|min:0|required_if:price_option,berbayar',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_lokasi' => ['required', Rule::in(['terkenal', 'hidden gem'])],
        ]);

        $validated = $this->applyOperationalSchedule($request, $validated);
        $validated = $this->applyPriceOption($request, $validated);
        $validated['transport_modes'] = $request->input('transport_modes', []);
        $validated['location'] = $validated['place_address'] . ', ' . $validated['city'] . ', ' . $validated['province'];
        $validated['image_url'] = $this->storeImage($request, $destination->image_url);

        $destination->update($validated);

        $this->writeAuditLog('update', 'destinations', $destination->getKey(), $before, $destination->fresh()->toArray());

        return redirect()->route('admin.dashboard')->with('success', 'Destinasi berhasil diperbarui.');
    }

    public function destinationDestroy(Destination $destination)
    {
        $before = $destination->toArray();
        $key = $destination->getKey();

        $this->deleteImageIfExists($destination->image_url);

        $destination->delete();

        $this->writeAuditLog('delete', 'destinations', $key, $before, null);

        return redirect()->route('admin.dashboard')->with('success', 'Destinasi berhasil dihapus.');
    }

    public function culinaryShow(Culinary $culinary)
    {
        return view('admin.culinaries.show', compact('culinary'));
    }

    public function culinaryCreate()
    {
        return view('admin.culinaries.form', [
            'culinary' => new Culinary(),
            'isEdit' => false,
        ]);
    }

    public function culinaryStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'place_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'operational_days_option' => 'nullable|in:setiap hari,hari tertentu',
            'operational_days_custom' => 'nullable|string|max:255|required_if:operational_days_option,hari tertentu',
            'operational_hours_option' => 'nullable|in:24 jam,jam tertentu',
            'operational_hours_custom' => 'nullable|string|max:255|required_if:operational_hours_option,jam tertentu',
            'operational_days' => 'nullable|string|max:255',
            'operational_hours' => 'nullable|string|max:255',
            'transport_modes' => 'nullable|array',
            'transport_modes.*' => 'in:mobil,motor,jalan kaki,bus,kapal',
            'price_option' => 'required|in:gratis,berbayar',
            'price_custom' => 'nullable|numeric|min:0|required_if:price_option,berbayar',
            'price' => 'nullable|numeric|min:0',
            'cuisine_type' => 'required|in:makanan tradisional,makanan khas daerah,makanan ringan,jajanan kaki lima,makanan laut,makanan cepat saji,makanan penutup,minuman',
            'amenities' => 'nullable|array',
            'amenities.*' => 'in:free wifi,free parking,toilet,mushola,ruang keluarga,live music,reservasi,pembayaran tunai,pembayaran non tunai,takeaway',
            'description' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_lokasi' => ['required', Rule::in(['terkenal', 'hidden gem'])],
        ]);

        $validated = $this->applyOperationalSchedule($request, $validated);
        $validated = $this->applyPriceOption($request, $validated);
        $validated['transport_modes'] = $request->input('transport_modes', []);
        $validated['amenities'] = $this->normalizeAmenities($request->input('amenities', []));
        $validated['location'] = $validated['place_address'] . ', ' . $validated['city'] . ', ' . $validated['province'];
        $validated['image_url'] = $this->storeImage($request, null);

        // Keep legacy DB column filled, but rating source is now user-generated.
        $validated['rating'] = 0;

        $culinary = Culinary::create($validated);

        $this->writeAuditLog('create', 'culinaries', $culinary->getKey(), null, $culinary->toArray());

        return redirect()->route('admin.dashboard')->with('success', 'Data kuliner berhasil ditambahkan.');
    }

    public function culinaryEdit(Culinary $culinary)
    {
        return view('admin.culinaries.form', [
            'culinary' => $culinary,
            'isEdit' => true,
        ]);
    }

    public function culinaryUpdate(Request $request, Culinary $culinary)
    {
        $before = $culinary->toArray();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'place_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'operational_days_option' => 'nullable|in:setiap hari,hari tertentu',
            'operational_days_custom' => 'nullable|string|max:255|required_if:operational_days_option,hari tertentu',
            'operational_hours_option' => 'nullable|in:24 jam,jam tertentu',
            'operational_hours_custom' => 'nullable|string|max:255|required_if:operational_hours_option,jam tertentu',
            'operational_days' => 'nullable|string|max:255',
            'operational_hours' => 'nullable|string|max:255',
            'transport_modes' => 'nullable|array',
            'transport_modes.*' => 'in:mobil,motor,jalan kaki,bus,kapal',
            'price_option' => 'required|in:gratis,berbayar',
            'price_custom' => 'nullable|numeric|min:0|required_if:price_option,berbayar',
            'price' => 'nullable|numeric|min:0',
            'cuisine_type' => 'required|in:makanan tradisional,makanan khas daerah,makanan ringan,jajanan kaki lima,makanan laut,makanan cepat saji,makanan penutup,minuman',
            'amenities' => 'nullable|array',
            'amenities.*' => 'in:free wifi,free parking,toilet,mushola,ruang keluarga,live music,reservasi,pembayaran tunai,pembayaran non tunai,takeaway',
            'description' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_lokasi' => ['required', Rule::in(['terkenal', 'hidden gem'])],
        ]);

        $validated = $this->applyOperationalSchedule($request, $validated);
        $validated = $this->applyPriceOption($request, $validated);
        $validated['transport_modes'] = $request->input('transport_modes', []);
        $validated['amenities'] = $this->normalizeAmenities($request->input('amenities', []));
        $validated['location'] = $validated['place_address'] . ', ' . $validated['city'] . ', ' . $validated['province'];
        $validated['image_url'] = $this->storeImage($request, $culinary->image_url);

        $culinary->update($validated);

        $this->writeAuditLog('update', 'culinaries', $culinary->getKey(), $before, $culinary->fresh()->toArray());

        return redirect()->route('admin.dashboard')->with('success', 'Data kuliner berhasil diperbarui.');
    }

    public function culinaryDestroy(Culinary $culinary)
    {
        $before = $culinary->toArray();
        $key = $culinary->getKey();

        $this->deleteImageIfExists($culinary->image_url);

        $culinary->delete();

        $this->writeAuditLog('delete', 'culinaries', $key, $before, null);

        return redirect()->route('admin.dashboard')->with('success', 'Data kuliner berhasil dihapus.');
    }

    public function stayShow(Stay $stay)
    {
        return view('admin.stays.show', compact('stay'));
    }

    public function stayCreate()
    {
        return view('admin.stays.form', [
            'stay' => new Stay(),
            'isEdit' => false,
        ]);
    }

    public function stayStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'place_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'operational_days_option' => 'nullable|in:setiap hari,hari tertentu',
            'operational_days_custom' => 'nullable|string|max:255|required_if:operational_days_option,hari tertentu',
            'operational_hours_option' => 'nullable|in:24 jam,jam tertentu',
            'operational_hours_custom' => 'nullable|string|max:255|required_if:operational_hours_option,jam tertentu',
            'operational_days' => 'nullable|string|max:255',
            'operational_hours' => 'nullable|string|max:255',
            'transport_modes' => 'nullable|array',
            'transport_modes.*' => 'in:mobil,motor,jalan kaki,bus,kapal',
            'price_option' => 'required|in:gratis,berbayar',
            'price_custom' => 'nullable|numeric|min:0|required_if:price_option,berbayar',
            'price' => 'nullable|numeric|min:0',
            'amenities' => 'nullable|array',
            'amenities.*' => 'in:wifi,ac,parkir,sarapan,restoran,kolam renang,air panas,tv,kamar mandi dalam,resepsionis 24 jam',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_lokasi' => ['required', Rule::in(['terkenal', 'hidden gem'])],
        ]);

        $validated = $this->applyOperationalSchedule($request, $validated);
        $validated = $this->applyPriceOption($request, $validated);
        $validated['transport_modes'] = $request->input('transport_modes', []);
        $validated['amenities'] = $this->normalizeAmenities($request->input('amenities', []));
        $validated['location'] = $validated['place_address'] . ', ' . $validated['city'] . ', ' . $validated['province'];
        $validated['image_url'] = $this->storeImage($request, null);

        $stay = Stay::create($validated);

        $this->writeAuditLog('create', 'stays', $stay->getKey(), null, $stay->toArray());

        return redirect()->route('admin.dashboard')->with('success', 'Data penginapan berhasil ditambahkan.');
    }

    public function stayEdit(Stay $stay)
    {
        return view('admin.stays.form', [
            'stay' => $stay,
            'isEdit' => true,
        ]);
    }

    public function stayUpdate(Request $request, Stay $stay)
    {
        $before = $stay->toArray();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'place_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'operational_days_option' => 'nullable|in:setiap hari,hari tertentu',
            'operational_days_custom' => 'nullable|string|max:255|required_if:operational_days_option,hari tertentu',
            'operational_hours_option' => 'nullable|in:24 jam,jam tertentu',
            'operational_hours_custom' => 'nullable|string|max:255|required_if:operational_hours_option,jam tertentu',
            'operational_days' => 'nullable|string|max:255',
            'operational_hours' => 'nullable|string|max:255',
            'transport_modes' => 'nullable|array',
            'transport_modes.*' => 'in:mobil,motor,jalan kaki,bus,kapal',
            'price_option' => 'required|in:gratis,berbayar',
            'price_custom' => 'nullable|numeric|min:0|required_if:price_option,berbayar',
            'price' => 'nullable|numeric|min:0',
            'amenities' => 'nullable|array',
            'amenities.*' => 'in:wifi,ac,parkir,sarapan,restoran,kolam renang,air panas,tv,kamar mandi dalam,resepsionis 24 jam',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_lokasi' => ['required', Rule::in(['terkenal', 'hidden gem'])],
        ]);

        $validated = $this->applyOperationalSchedule($request, $validated);
        $validated = $this->applyPriceOption($request, $validated);
        $validated['transport_modes'] = $request->input('transport_modes', []);
        $validated['amenities'] = $this->normalizeAmenities($request->input('amenities', []));
        $validated['location'] = $validated['place_address'] . ', ' . $validated['city'] . ', ' . $validated['province'];
        $validated['image_url'] = $this->storeImage($request, $stay->image_url);

        $stay->update($validated);

        $this->writeAuditLog('update', 'stays', $stay->getKey(), $before, $stay->fresh()->toArray());

        return redirect()->route('admin.dashboard')->with('success', 'Data penginapan berhasil diperbarui.');
    }

    public function stayDestroy(Stay $stay)
    {
        $before = $stay->toArray();
        $key = $stay->getKey();

        $this->deleteImageIfExists($stay->image_url);

        $stay->delete();

        $this->writeAuditLog('delete', 'stays', $key, $before, null);

        return redirect()->route('admin.dashboard')->with('success', 'Data penginapan berhasil dihapus.');
    }

    /**
     * Menyimpan rekam jejak perubahan entity ke tabel audit log.
     */
    private function writeAuditLog(string $action, string $entityType, int $entityId, ?array $beforeData, ?array $afterData): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'admin_name' => Auth::user()?->username,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'before_data' => $beforeData,
            'after_data' => $afterData,
            'changed_at' => now(),
        ]);
    }

    private function storeImage(Request $request, ?string $oldPath): ?string
    {
        if (!$request->hasFile('image_file')) {
            return $oldPath;
        }

        if (!empty($oldPath)) {
            $this->deleteImageIfExists($oldPath);
        }

        return $request->file('image_file')->store('uploads', 'public');
    }

    /**
     * Menormalisasi input jadwal operasional harian ke format yang konsisten.
     */
    private function applyOperationalSchedule(Request $request, array $validated): array
    {
        $weeklySchedule = $request->input('operational_schedule');

        if (is_array($weeklySchedule) && !empty($weeklySchedule)) {
            $normalizedSchedule = [];

            foreach (self::WEEK_DAYS as $dayKey => $dayLabel) {
                $dayInput = $weeklySchedule[$dayKey] ?? [];
                $status = strtolower((string) ($dayInput['status'] ?? 'closed'));

                if (!in_array($status, ['open', 'full_day', 'closed'], true)) {
                    $status = 'closed';
                }

                $openTime = trim((string) ($dayInput['open_time'] ?? ''));
                $closeTime = trim((string) ($dayInput['close_time'] ?? ''));

                if ($status === 'full_day') {
                    $openTime = '00:00';
                    $closeTime = '23:59';
                } elseif ($status !== 'open') {
                    $openTime = '';
                    $closeTime = '';
                }

                $normalizedSchedule[] = [
                    'day' => $dayKey,
                    'label' => $dayLabel,
                    'status' => $status,
                    'open_time' => $openTime,
                    'close_time' => $closeTime,
                ];
            }

            [$daysSummary, $hoursSummary] = $this->summarizeOperationalSchedule($normalizedSchedule);

            $validated['operational_schedule'] = $normalizedSchedule;
            $validated['operational_days'] = $daysSummary;
            $validated['operational_hours'] = $hoursSummary;

            unset(
                $validated['operational_days_option'],
                $validated['operational_days_custom'],
                $validated['operational_hours_option'],
                $validated['operational_hours_custom']
            );

            return $validated;
        }

        $daysOption = $request->input('operational_days_option');
        $daysCustom = trim((string) $request->input('operational_days_custom', ''));

        if ($daysOption === 'setiap hari') {
            $validated['operational_days'] = 'setiap hari';
        } elseif ($daysOption === 'hari tertentu') {
            $validated['operational_days'] = $daysCustom !== '' ? $daysCustom : null;
        }

        $hoursOption = $request->input('operational_hours_option');
        $hoursCustom = trim((string) $request->input('operational_hours_custom', ''));

        if ($hoursOption === '24 jam') {
            $validated['operational_hours'] = '24 jam';
        } elseif ($hoursOption === 'jam tertentu') {
            $validated['operational_hours'] = $hoursCustom !== '' ? $hoursCustom : null;
        }

        unset(
            $validated['operational_days_option'],
            $validated['operational_days_custom'],
            $validated['operational_hours_option'],
            $validated['operational_hours_custom']
        );

        return $validated;
    }

    /**
     * Membuat ringkasan teks hari dan jam operasional dari struktur jadwal mingguan.
     */
    private function summarizeOperationalSchedule(array $schedule): array
    {
        $openDays = array_filter($schedule, static fn (array $row) => in_array(($row['status'] ?? 'closed'), ['open', 'full_day'], true));

        if (empty($openDays)) {
            return ['Libur setiap hari', 'Libur setiap hari'];
        }

        $allOpen = count($openDays) === count($schedule);
        $sameHours = count(array_unique(array_map(
            static fn (array $row) => ($row['open_time'] ?? '') . '-' . ($row['close_time'] ?? ''),
            $openDays
        ))) === 1;

        if ($allOpen && $sameHours) {
            $first = $openDays[array_key_first($openDays)];

            return [
                'Setiap hari',
                ($first['status'] ?? 'open') === 'full_day'
                    ? '24 jam'
                    : trim(($first['open_time'] ?? '') . ' - ' . ($first['close_time'] ?? '')),
            ];
        }

        $daysParts = [];
        $hoursParts = [];

        foreach ($schedule as $row) {
            $label = $row['label'] ?? ucfirst((string) ($row['day'] ?? '-'));

            if (($row['status'] ?? 'closed') === 'full_day') {
                $daysParts[] = $label . ': 24 Jam';
                $hoursParts[] = $label . ': 24 Jam';
            } elseif (($row['status'] ?? 'closed') === 'open') {
                $daysParts[] = $label . ': Buka';
                $hoursParts[] = $label . ': ' . trim(($row['open_time'] ?? '') . ' - ' . ($row['close_time'] ?? ''));
            } else {
                $daysParts[] = $label . ': Libur';
                $hoursParts[] = $label . ': Libur';
            }
        }

        return [implode(', ', $daysParts), implode(', ', $hoursParts)];
    }

    /**
     * Membersihkan daftar fasilitas agar tersimpan rapi sebagai teks terpisah koma.
     */
    private function normalizeAmenities(array $amenities): ?string
    {
        $cleaned = array_values(array_filter(array_map(static fn ($item) => trim((string) $item), $amenities)));

        return empty($cleaned) ? null : implode(', ', $cleaned);
    }

    /**
     * Mengubah pilihan harga gratis/berbayar menjadi nilai numerik final.
     */
    private function applyPriceOption(Request $request, array $validated): array
    {
        $priceOption = $request->input('price_option');
        $priceCustom = $request->input('price_custom');

        if ($priceOption === 'gratis') {
            $validated['price'] = 0;
        } else {
            $validated['price'] = is_null($priceCustom) ? 0 : (float) $priceCustom;
        }

        unset(
            $validated['price_option'],
            $validated['price_custom']
        );

        return $validated;
    }

    private function deleteImageIfExists(?string $path): void
    {
        if (!empty($path) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Guard endpoint agar hanya role admin yang dapat mengakses fitur ini.
     */
    private function ensureAdmin(): void
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
    }
}
