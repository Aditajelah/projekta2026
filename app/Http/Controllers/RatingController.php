<?php

namespace App\Http\Controllers;

use App\Models\Culinary;
use App\Models\Destination;
use App\Models\Rating;
use App\Models\Stay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, string $type, int $id)
    {
        if (Auth::user()->role !== 'member') {
            return back()->withErrors(['rating' => 'Hanya member yang dapat memberikan rating.']);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:2000',
        ]);

        $modelMap = [
            'destination' => [Destination::class, 'id_destinations'],
            'culinary' => [Culinary::class, 'id_culinaries'],
            'stay' => [Stay::class, 'id_stays'],
        ];

        if (!isset($modelMap[$type])) {
            abort(404);
        }

        [$modelClass, $key] = $modelMap[$type];
        $item = $modelClass::where($key, $id)->firstOrFail();

        Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'rateable_type' => $modelClass,
                'rateable_id' => $item->getKey(),
            ],
            [
                'rating' => $validated['rating'],
                'review' => $validated['review'] ?? null,
            ]
        );

        return back()->with('success', 'Rating berhasil disimpan.');
    }
}
