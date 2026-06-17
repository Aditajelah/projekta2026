<?php

namespace App\Http\Controllers;

use App\Models\Culinary;
use App\Models\Destination;
use App\Models\Rating;
use App\Models\Stay;

class HomeController extends Controller
{
    // Minimum jumlah rating agar nilai rata-rata tempat dianggap cukup stabil.
    private const MIN_RATING_COUNT_FOR_FULL_CONFIDENCE = 10;

    /**
     * Menyiapkan data halaman landing termasuk top tempat berbobot rating.
     */
    public function index()
    {
        $destinationCount = Destination::count();
        $culinaryCount = Culinary::count();
        $stayCount = Stay::count();

        $globalAverageRating = (float) (Rating::whereNotNull('rating')->avg('rating') ?? 0);

        $topDestinations = Destination::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->whereHas('ratings')
            ->get()
            ->map(function ($item) use ($globalAverageRating) {
                $item->weighted_rating = $this->weightedScore(
                    $item->user_rating_avg,
                    $item->ratings_count,
                    $globalAverageRating
                );

                return $item;
            })
            ->sortByDesc('weighted_rating')
            ->take(3)
            ->values();

        $topCulinaries = Culinary::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->whereHas('ratings')
            ->get()
            ->map(function ($item) use ($globalAverageRating) {
                $item->weighted_rating = $this->weightedScore(
                    $item->user_rating_avg,
                    $item->ratings_count,
                    $globalAverageRating
                );

                return $item;
            })
            ->sortByDesc('weighted_rating')
            ->take(3)
            ->values();

        $topStays = Stay::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->whereHas('ratings')
            ->get()
            ->map(function ($item) use ($globalAverageRating) {
                $item->weighted_rating = $this->weightedScore(
                    $item->user_rating_avg,
                    $item->ratings_count,
                    $globalAverageRating
                );

                return $item;
            })
            ->sortByDesc('weighted_rating')
            ->take(3)
            ->values();

        return view('welcome', compact(
            'destinationCount',
            'culinaryCount',
            'stayCount',
            'topDestinations',
            'topCulinaries',
            'topStays'
        ));
    }

    /**
     * Menghitung weighted score agar jumlah reviewer ikut mempengaruhi ranking.
     */
    private function weightedScore(?float $average, int $count, float $globalAverage): float
    {
        if (is_null($average) || $count <= 0) {
            return 0;
        }

        $minimumCount = self::MIN_RATING_COUNT_FOR_FULL_CONFIDENCE;

        return (($count / ($count + $minimumCount)) * $average)
            + (($minimumCount / ($count + $minimumCount)) * $globalAverage);
    }
}
