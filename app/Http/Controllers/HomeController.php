<?php

namespace App\Http\Controllers;

use App\Models\Culinary;
use App\Models\Destination;
use App\Models\Stay;

class HomeController extends Controller
{
    public function index()
    {
        $destinationCount = Destination::count();
        $culinaryCount = Culinary::count();
        $stayCount = Stay::count();

        $topDestinations = Destination::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->having('ratings_count', '>', 0)
            ->orderByDesc('user_rating_avg')
            ->limit(3)
            ->get();

        $topCulinaries = Culinary::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->having('ratings_count', '>', 0)
            ->orderByDesc('user_rating_avg')
            ->limit(3)
            ->get();

        $topStays = Stay::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->having('ratings_count', '>', 0)
            ->orderByDesc('user_rating_avg')
            ->limit(3)
            ->get();

        return view('welcome', compact(
            'destinationCount',
            'culinaryCount',
            'stayCount',
            'topDestinations',
            'topCulinaries',
            'topStays'
        ));
    }
}
