<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDataController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes (require login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/places', [DashboardController::class, 'managePlaces'])->name('admin.places.index');
    Route::get('/admin/comments', [AdminDataController::class, 'comments'])->name('admin.comments.index');
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/logs', [AdminDataController::class, 'logs'])->name('admin.logs');
    Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');

    Route::get('/explore/destinations', [ExploreController::class, 'destinations'])->name('explore.destinations');
    Route::get('/explore/destinations/{destination}', [ExploreController::class, 'destinationShow'])->name('explore.destinations.show');
    Route::get('/explore/culinaries', [ExploreController::class, 'culinaries'])->name('explore.culinaries');
    Route::get('/explore/culinaries/{culinary}', [ExploreController::class, 'culinaryShow'])->name('explore.culinaries.show');
    Route::get('/explore/stays', [ExploreController::class, 'stays'])->name('explore.stays');
    Route::get('/explore/stays/{stay}', [ExploreController::class, 'stayShow'])->name('explore.stays.show');

    Route::post('/ratings/{type}/{id}', [RatingController::class, 'store'])->name('ratings.store');
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks/{type}/{id}', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{type}/{id}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');

    Route::get('/admin/destinations/create', [AdminDataController::class, 'destinationCreate'])->name('admin.destinations.create');
    Route::post('/admin/destinations', [AdminDataController::class, 'destinationStore'])->name('admin.destinations.store');
    Route::get('/admin/destinations/{destination}', [AdminDataController::class, 'destinationShow'])->name('admin.destinations.show');
    Route::get('/admin/destinations/{destination}/edit', [AdminDataController::class, 'destinationEdit'])->name('admin.destinations.edit');
    Route::put('/admin/destinations/{destination}', [AdminDataController::class, 'destinationUpdate'])->name('admin.destinations.update');
    Route::delete('/admin/destinations/{destination}', [AdminDataController::class, 'destinationDestroy'])->name('admin.destinations.destroy');

    Route::get('/admin/culinaries/create', [AdminDataController::class, 'culinaryCreate'])->name('admin.culinaries.create');
    Route::post('/admin/culinaries', [AdminDataController::class, 'culinaryStore'])->name('admin.culinaries.store');
    Route::get('/admin/culinaries/{culinary}', [AdminDataController::class, 'culinaryShow'])->name('admin.culinaries.show');
    Route::get('/admin/culinaries/{culinary}/edit', [AdminDataController::class, 'culinaryEdit'])->name('admin.culinaries.edit');
    Route::put('/admin/culinaries/{culinary}', [AdminDataController::class, 'culinaryUpdate'])->name('admin.culinaries.update');
    Route::delete('/admin/culinaries/{culinary}', [AdminDataController::class, 'culinaryDestroy'])->name('admin.culinaries.destroy');

    Route::get('/admin/stays/create', [AdminDataController::class, 'stayCreate'])->name('admin.stays.create');
    Route::post('/admin/stays', [AdminDataController::class, 'stayStore'])->name('admin.stays.store');
    Route::get('/admin/stays/{stay}', [AdminDataController::class, 'stayShow'])->name('admin.stays.show');
    Route::get('/admin/stays/{stay}/edit', [AdminDataController::class, 'stayEdit'])->name('admin.stays.edit');
    Route::put('/admin/stays/{stay}', [AdminDataController::class, 'stayUpdate'])->name('admin.stays.update');
    Route::delete('/admin/stays/{stay}', [AdminDataController::class, 'stayDestroy'])->name('admin.stays.destroy');
});
