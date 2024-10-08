<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/book/{id}',[HomeController::class,'detail'])->name('book.detail');
Route::post('/save-book-review',[HomeController::class,'saveReview'])->name('book.saveReview');

Route::group(['prefix' => 'account'],function(){
    Route::group(['middleware' => 'guest'],function(){
        Route::get('register',[AccountController::class,'register'])->name('account.register');
        Route::post('register',[AccountController::class,'processRegister'])->name('account.processRegister');
        Route::get('login',[AccountController::class,'login'])->name('account.login');
        Route::post('login',[AccountController::class,'authenticate'])->name('account.authenticate');
    });
    Route::group(['middleware' => 'auth'],function(){

        Route::group(['middleware' => 'chake_admin'], function(){
            Route::get('books',[BookController::class, 'index'])->name('books.index');
            Route::get('books/create',[BookController::class, 'creata'])->name('books.create');
            Route::post('books',[BookController::class, 'store'])->name('books.store');
            Route::get('books/edit/{id}',[BookController::class, 'edit'])->name('books.edit');
            Route::post('books/edit/{id}',[BookController::class, 'update'])->name('books.update');
            Route::delete('books',[BookController::class, 'destroy'])->name('books.destroy');

            Route::get('reviews',[ReviewController::class, 'index'])->name('account.reviews');
            Route::get('reviews/{id}',[ReviewController::class,'edit'])->name('account.review.edit');
            Route::post('reviews/{id}',[ReviewController::class, 'updateReview'])->name('account.review.update');
            Route::post('delete-reviews',[ReviewController::class, 'deleteReview'])->name('account.review.deleteReview');
        });
        
        Route::get('profile',[AccountController::class,'profile'])->name('account.profile');
        Route::get('logout',[AccountController::class, 'logout'])->name('account.logout');
        Route::post('update-profile',[AccountController::class, 'update'])->name('update.profile');
      
        Route::get('my-eviews',[AccountController::class,'myReviews'])->name('account.myReviews');
        Route::get('my-eviews/{id}',[AccountController::class,'editMyReview'])->name('account.edit_my_review');
        Route::post('my-eviews/{id}',[AccountController::class,'updateMyReview'])->name('account.update_my_review');
        Route::post('delete-my-eviews',[AccountController::class,'deleteMyReview'])->name('account.delete_my_Reviews');
    });
});

