<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Culinary;
use App\Models\Destination;
use App\Models\Stay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::with('bookmarkable')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.bookmarks.index', compact('bookmarks'));
    }

    public function store(Request $request, string $type, int $id)
    {
        $model = $this->resolveType($type);
        $item = $model::query()->findOrFail($id);

        Bookmark::firstOrCreate([
            'user_id' => Auth::id(),
            'bookmarkable_type' => $model,
            'bookmarkable_id' => $item->getKey(),
        ]);

        return back()->with('success', 'Berhasil ditambahkan ke favorit.');
    }

    public function destroy(Request $request, string $type, int $id)
    {
        $model = $this->resolveType($type);

        Bookmark::where('user_id', Auth::id())
            ->where('bookmarkable_type', $model)
            ->where('bookmarkable_id', $id)
            ->delete();

        return back()->with('success', 'Berhasil dihapus dari favorit.');
    }

    private function resolveType(string $type): string
    {
        return match ($type) {
            'destination' => Destination::class,
            'culinary' => Culinary::class,
            'stay' => Stay::class,
            default => abort(404),
        };
    }
}
