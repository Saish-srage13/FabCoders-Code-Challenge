<?php

use App\Http\Controllers\MovieReviewController;
use App\Http\Controllers\Api\MovieReviewApiController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => '/movie-review'], function () {

    Route::get('/', [MovieReviewController::class, 'list'])->name('movie_review.list');
    Route::post('/', [MovieReviewApiController::class, 'create'])->name('movie_review.create');
    Route::get('/{id}', [MovieReviewApiController::class, 'getMovieReview'])->name('movie_review.get');
    Route::put('/{id}', [MovieReviewApiController::class, 'update'])->name('movie_review.update');
    Route::delete('/{id}', [MovieReviewApiController::class, 'delete'])->name('movie_review.delete');
    
});
