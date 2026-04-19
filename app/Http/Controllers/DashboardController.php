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

    private function topPlaces()
    {
        $destinations = Destination::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount(['ratings as comments_count' => function ($query) {
                $query->whereNotNull('review')->where('review', '!=', '');
            }])
            ->get()
            ->map(function ($place) {
                return [
                    'name' => $place->name,
                    'type' => 'Destinasi',
                    'type_class' => 'type-destination',
                    'rating' => $place->user_rating_avg,
                    'comments_count' => $place->comments_count,
                    'detail_url' => route('admin.destinations.show', $place),
                ];
            });

        $culinaries = Culinary::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount(['ratings as comments_count' => function ($query) {
                $query->whereNotNull('review')->where('review', '!=', '');
            }])
            ->get()
            ->map(function ($place) {
                return [
                    'name' => $place->name,
                    'type' => 'Kuliner',
                    'type_class' => 'type-culinary',
                    'rating' => $place->user_rating_avg,
                    'comments_count' => $place->comments_count,
                    'detail_url' => route('admin.culinaries.show', $place),
                ];
            });

        $stays = Stay::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount(['ratings as comments_count' => function ($query) {
                $query->whereNotNull('review')->where('review', '!=', '');
            }])
            ->get()
            ->map(function ($place) {
                return [
                    'name' => $place->name,
                    'type' => 'Penginapan',
                    'type_class' => 'type-stay',
                    'rating' => $place->user_rating_avg,
                    'comments_count' => $place->comments_count,
                    'detail_url' => route('admin.stays.show', $place),
                ];
            });

        return $destinations
            ->merge($culinaries)
            ->merge($stays)
            ->filter(fn ($place) => !is_null($place['rating']))
            ->sortByDesc('rating')
            ->take(3)
            ->values();
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
