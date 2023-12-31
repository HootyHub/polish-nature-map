<?php

use App\Enums\Permissions;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ImporterController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\PersonalMapController;
use App\Http\Controllers\SpatialFeatureController;
use App\Http\Controllers\VisitsController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('index');

Route::group(['middleware' => [
    'auth:sanctum',
    config('jetstream.auth_session'),
    Authorize::using(Permissions::VIEW_ADMIN_PANEL->value),
]], function () {
    Route::group(['middleware' => [Authorize::using(Permissions::VIEW_IMPORTERS->value)]], function () {
        Route::get('/admin/importers', [ImporterController::class, 'index'])->name('admin.importers.index');
        Route::post('/admin/importers/runAll', [ImporterController::class, 'runAll'])->name('admin.importers.runAll');
        Route::post('/admin/importers/run', [ImporterController::class, 'run'])->name('admin.importers.run');
        Route::post('/admin/importers/describe', [ImporterController::class, 'updatePlacesDescriptions'])->name('admin.importers.describe');
    });

    Route::group(['middleware' => [Authorize::using(Permissions::VIEW_CATEGORIES->value)]], function () {
        Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::post('/admin/categories/{category}', [CategoryController::class, 'uploadImage'])->name('admin.categories.uploadImage');
    });
    Route::group(['middleware' => [Authorize::using(Permissions::VIEW_STATISTICS->value)]], function () {
        Route::get('/admin/statistics', [StatisticsController::class, 'index'])->name('admin.statistics.index');
    });
}
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('/visits/{placeId}', [VisitsController::class, 'visit']);
    Route::delete('/visits/{placeId}', [VisitsController::class, 'unvisit']);
});

Route::middleware([
    'auth:sanctum',
])->group(function () {
    Route::get('/map/me', [PersonalMapController::class, 'me'])->name('map.me');
    Route::put('/share', [PersonalMapController::class, 'share'])->name('map.share');
});

Route::get('/map/{name}', [PersonalMapController::class, 'show'])->name('map');

Route::get('/features/id/{id}', [SpatialFeatureController::class, 'show']);
Route::get('/features/search', [SpatialFeatureController::class, 'search']);
Route::get('/features/filterIds', [SpatialFeatureController::class, 'filterIds']);
