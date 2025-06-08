<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\applicationController;
use App\Http\Controllers\gallaryController;
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

Route::get('/', function () {
    return view('welcome');
});//login page

Route::get('/dashboard', function () {
    return view('dashboard');//after login page dashboard page
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('applications/create', [applicationController::class, 'create'])->name('application.create');//blade file for create page
    Route::get('applications/index', [applicationController::class, 'index'])->name('application.index');//blade file for index page
    Route::post('applications/store', [applicationController::class, 'store'])->name('application.store');//function to store the data in db table
    Route::post('applications/update/{id}', [applicationController::class, 'update'])->name('application.update');//function to updation
    Route::get('applications/edit/{id}', [applicationController::class, 'edit'])->name('application.edit');//blade file for edit page
    Route::get('applications/delete/{id}', [applicationController::class, 'delete'])->name('application.delete');//for deletion

    Route::get('gallery/create', [gallaryController::class, 'create'])->name('gallery.create');//blade file for create page
    Route::get('gallery/index', [gallaryController::class, 'index'])->name('gallery.index');//blade file for index page
    Route::post('gallery/store', [gallaryController::class, 'store'])->name('gallery.store');//function to store the data in db table
    Route::post('gallery/update/{id}', [gallaryController::class, 'update'])->name('gallery.update');//function to updation
    Route::get('gallery/edit/{id}', [gallaryController::class, 'edit'])->name('gallery.edit');//blade file for edit page
    Route::get('gallery/delete/{id}', [gallaryController::class, 'delete'])->name('gallery.delete');//for deletion

});

require __DIR__.'/auth.php';
