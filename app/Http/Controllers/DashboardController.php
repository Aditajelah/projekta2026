<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Culinary;
use App\Models\Stay;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Nilai minimum rating count untuk smoothing skor berbobot.
    private const MIN_RATING_COUNT_FOR_FULL_CONFIDENCE = 10;

    /**
     * Mengarahkan user ke dashboard berdasarkan role (admin/member).
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }

    /**
     * Show admin dashboard with all data
     */
    public function adminDashboard()
    {
        $destinationCount = Destination::count();
        $culinaryCount = Culinary::count();
        $stayCount = Stay::count();
        $commentCount = Rating::whereNotNull('review')
            ->where('review', '!=', '')
            ->count();
        $topPlaces = $this->topPlaces();
        
        return view('admin.adminDashboard', [
            'destinationCount' => $destinationCount,
            'culinaryCount' => $culinaryCount,
            'stayCount' => $stayCount,
            'commentCount' => $commentCount,
            'topPlaces' => $topPlaces,
        ]);
    }

    /**
     * Menyusun daftar top tempat lintas kategori dengan ranking weighted rating.
     */
    private function topPlaces()
    {
        $globalAverageRating = (float) (Rating::whereNotNull('rating')->avg('rating') ?? 0);

        $destinations = Destination::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->withCount(['ratings as comments_count' => function ($query) {
                $query->whereNotNull('review')->where('review', '!=', '');
            }])
            ->get()
            ->map(function ($place) use ($globalAverageRating) {
                return [
                    'name' => $place->name,
                    'type' => 'Destinasi',
                    'type_class' => 'type-destination',
                    'rating' => $place->user_rating_avg,
                    'weighted_rating' => $this->weightedScore($place->user_rating_avg, $place->ratings_count, $globalAverageRating),
                    'comments_count' => $place->comments_count,
                    'detail_url' => route('admin.destinations.show', $place),
                ];
            });

        $culinaries = Culinary::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->withCount(['ratings as comments_count' => function ($query) {
                $query->whereNotNull('review')->where('review', '!=', '');
            }])
            ->get()
            ->map(function ($place) use ($globalAverageRating) {
                return [
                    'name' => $place->name,
                    'type' => 'Kuliner',
                    'type_class' => 'type-culinary',
                    'rating' => $place->user_rating_avg,
                    'weighted_rating' => $this->weightedScore($place->user_rating_avg, $place->ratings_count, $globalAverageRating),
                    'comments_count' => $place->comments_count,
                    'detail_url' => route('admin.culinaries.show', $place),
                ];
            });

        $stays = Stay::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->withCount(['ratings as comments_count' => function ($query) {
                $query->whereNotNull('review')->where('review', '!=', '');
            }])
            ->get()
            ->map(function ($place) use ($globalAverageRating) {
                return [
                    'name' => $place->name,
                    'type' => 'Penginapan',
                    'type_class' => 'type-stay',
                    'rating' => $place->user_rating_avg,
                    'weighted_rating' => $this->weightedScore($place->user_rating_avg, $place->ratings_count, $globalAverageRating),
                    'comments_count' => $place->comments_count,
                    'detail_url' => route('admin.stays.show', $place),
                ];
            });

        return $destinations
            ->merge($culinaries)
            ->merge($stays)
            ->filter(fn ($place) => !is_null($place['rating']))
            ->sortByDesc('weighted_rating')
            ->take(3)
            ->values();
    }

    /**
     * Menghitung skor rating berbobot untuk mengurangi bias rating dengan sampel kecil.
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

    /**
     * Show admin page for place management
     */
    public function managePlaces()
    {
        $destinationCount = Destination::count();
        $culinaryCount = Culinary::count();
        $stayCount = Stay::count();

        $destinations = Destination::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->latest()
            ->get();
        $culinary = Culinary::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->latest()
            ->get();
        $stays = Stay::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->latest()
            ->get();

        return view('admin.managePlaces', [
            'destinationCount' => $destinationCount,
            'culinaryCount' => $culinaryCount,
            'stayCount' => $stayCount,
            'destinations' => $destinations,
            'culinary' => $culinary,
            'stays' => $stays,
        ]);
    }

    /**
     * Show user dashboard
     */
    public function userDashboard()
    {
        return view('userDashboard');
    }
}
