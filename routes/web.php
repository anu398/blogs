<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

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
});
// users
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::get('blogs/published', [BlogController::class, 'publishedBlogs'])->name('blogs.published');
    Route::get('blogs/view/{id}', [BlogController::class, 'viewMore'])->name('blogs.view');
    Route::resource('blogs', BlogController::class);

});


Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('admin.dashboard');

    Route::get('admin/blogs', [BlogController::class, 'index'])->name('admin.blogs.index');
    Route::post('admin/blogs/{blog}/status', [BlogController::class, 'changeStatus'])->name('admin.blogs.status');
    Route::get('admin/blogs/published', [BlogController::class, 'publishedBlogs'])->name('admin.blogs.published');
    Route::get('admin/blogs/view/{id}', [BlogController::class, 'viewMore'])->name('admin.blogs.view');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
