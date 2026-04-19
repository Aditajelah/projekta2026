<?php

namespace App\Http\Controllers;

use App\Models\Culinary;
use App\Models\Destination;
use App\Models\Stay;
use Illuminate\Support\Facades\Auth;

class ExploreController extends Controller
{
    public function destinations()
    {
        $items = Destination::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->latest()
            ->paginate(12);

        return view('user.explore.destinations.index', compact('items'));
    }

    public function destinationShow(Destination $destination)
    {
        $userRating = $destination->ratings()->where('user_id', Auth::id())->first();
        $avgRating = $destination->ratings()->avg('rating');
        $isBookmarked = $destination->bookmarks()->where('user_id', Auth::id())->exists();

        return view('user.explore.destinations.show', compact('destination', 'userRating', 'avgRating', 'isBookmarked'));
    }

    public function culinaries()
    {
        $items = Culinary::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->latest()
            ->paginate(12);

        return view('user.explore.culinaries.index', compact('items'));
    }

    public function culinaryShow(Culinary $culinary)
    {
        $userRating = $culinary->ratings()->where('user_id', Auth::id())->first();
        $avgRating = $culinary->ratings()->avg('rating');
        $isBookmarked = $culinary->bookmarks()->where('user_id', Auth::id())->exists();

        return view('user.explore.culinaries.show', compact('culinary', 'userRating', 'avgRating', 'isBookmarked'));
    }

    public function stays()
    {
        $items = Stay::withAvg('ratings as user_rating_avg', 'rating')
            ->withCount('ratings')
            ->latest()
            ->paginate(12);

        return view('user.explore.stays.index', compact('items'));
    }

    public function stayShow(Stay $stay)
    {
        $userRating = $stay->ratings()->where('user_id', Auth::id())->first();
        $avgRating = $stay->ratings()->avg('rating');
        $isBookmarked = $stay->bookmarks()->where('user_id', Auth::id())->exists();

        return view('user.explore.stays.show', compact('stay', 'userRating', 'avgRating', 'isBookmarked'));
    }
}
