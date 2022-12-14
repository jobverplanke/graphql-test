<?php

declare(strict_types=1);

use App\Http\Controllers\ExampleQueryBuilderController;
use App\Http\Controllers\ExampleRawFileQueryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/{pokemon}', ExampleQueryBuilderController::class);
Route::get('/{pokemon}/raw/one', [ExampleRawFileQueryController::class, 'methodOne']);
Route::get('/{pokemon}/raw/two', [ExampleRawFileQueryController::class, 'methodTwo']);
Route::get('/{pokemon}/raw/three', [ExampleRawFileQueryController::class, 'methodThree']);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
