<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AdoptionRequestController;

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
    return view('main');
});

// routes to do with the animal entries
Route::post('/animals', [AnimalController::class, 'store'])->name('animals.store');
Route::patch('/animals/{id}/edit', [AnimalController::class, 'update'])->name('animals.update');
Route::get('/animals/staff', [AnimalController::class, 'index'])->name('animals.index');
Route::get('/animals/add', [AnimalController::class, 'create'])->name('animals.create');
Route::get('/animals/{id}/edit', [AnimalController::class, 'edit'])->name('animals.edit');
Route::get('/animals/{id}', [AnimalController::class, 'show'])->name('animals.show');
Route::delete('/animals/{id}', [AnimalController::Class, 'destroy'])->name('animals.destroy');

// routes to do with the adoption requests
Route::get('/requests/staff', [AdoptionRequestController::class, 'getCompletedAdoptionRequests']);
Route::get('/requests/public', [AdoptionRequestController::class, 'getUserAdoptionRequests'])->name('requests.index');
Route::post('/requests', [AdoptionRequestController::class, 'store'])->name('requests.store');

// routes to do with the home pages
Route::patch('/home/staff', [AdoptionRequestController::class, 'update'])->name('requests.patch');
Route::get('/home/staff', [AdoptionRequestController::class, 'display']);
Route::get('/home/public', [AnimalController::class, 'availableAnimals']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();


