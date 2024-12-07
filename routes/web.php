<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('elenco_libri', [ 'as' => 'elenco_libri', 'uses' => 'App\Http\Controllers\MainController@elenco_libri']);
Route::post('elenco_libri', [ 'as' => 'elenco_libri', 'uses' => 'App\Http\Controllers\MainController@elenco_libri']);


Route::middleware('auth')->group(function () {
    Route::get('change_prefer', [ 'as' => 'change_prefer', 'uses' => 'App\Http\Controllers\MainController@change_prefer']);
    Route::post('change_prefer', [ 'as' => 'change_prefer', 'uses' => 'App\Http\Controllers\MainController@change_prefer']);

    Route::get('elenco_utenti', [ 'as' => 'elenco_utenti', 'uses' => 'App\Http\Controllers\ControllerAdmin@elenco_utenti']);
    Route::post('elenco_utenti', [ 'as' => 'elenco_utenti', 'uses' => 'App\Http\Controllers\ControllerAdmin@elenco_utenti']);

    Route::post('dele_user', [ 'as' => 'dele_user', 'uses' => 'App\Http\Controllers\ControllerAdmin@dele_user']);
    Route::post('save_user', [ 'as' => 'save_user', 'uses' => 'App\Http\Controllers\ControllerAdmin@save_user']);
    Route::post('load_info', [ 'as' => 'load_info', 'uses' => 'App\Http\Controllers\ControllerAdmin@load_info']);
    Route::post('load_prefer', [ 'as' => 'load_prefer', 'uses' => 'App\Http\Controllers\ControllerAdmin@load_prefer']);

    Route::get('libri', [ 'as' => 'libri', 'uses' => 'App\Http\Controllers\ControllerAdmin@libri']);
    Route::post('libri', [ 'as' => 'libri', 'uses' => 'App\Http\Controllers\ControllerAdmin@libri']);

    Route::post('dele_book', [ 'as' => 'dele_book', 'uses' => 'App\Http\Controllers\ControllerAdmin@dele_book']);
    Route::post('save_book', [ 'as' => 'save_book', 'uses' => 'App\Http\Controllers\ControllerAdmin@save_book']);
    Route::post('load_book', [ 'as' => 'load_book', 'uses' => 'App\Http\Controllers\ControllerAdmin@load_book']);

    
});

require __DIR__.'/auth.php';
