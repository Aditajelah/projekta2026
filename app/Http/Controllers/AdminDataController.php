<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Culinary;
use App\Models\Destination;
use App\Models\Rating;
use App\Models\Stay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminDataController extends Controller
{
    public function comments()
    {
        $comments = Rating::with(['user', 'rateable'])
            ->whereNotNull('review')
            ->where('review', '!=', '')
            ->latest()
            ->paginate(25);

        return view('admin.comments.index', compact('comments'));
    }

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

    private function applyOperationalSchedule(Request $request, array $validated): array
    {
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

    private function normalizeAmenities(array $amenities): ?string
    {
        $cleaned = array_values(array_filter(array_map(static fn ($item) => trim((string) $item), $amenities)));

        return empty($cleaned) ? null : implode(', ', $cleaned);
    }

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
}
