<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\DeckController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/cards', function () {
    return Inertia::render('Cards');
})->name('cards');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/my-decks', [DeckController::class, 'index'])->name('my-decks');
    Route::post('/my-decks/save', [DeckController::class, 'save']);
    Route::get('/new-deck', [DeckController::class, 'view'])->name('new-deck');
    Route::get('/view-deck/{deckId}', [DeckController::class, 'view'])->name('view-deck');
}); 


