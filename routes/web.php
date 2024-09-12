<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Blogcontroller;


//นักอ่าน
Route::get('/',[Blogcontroller::class,'index']);
Route::get('/detail/{id}',[Blogcontroller::class,'detail']);


//นักเขียน
Route::prefix('author')->group(function(){
    Route::get('/blog',[AdminController::class,'index'])->name('blog');
    Route::get('/create',[AdminController::class,'create']);
    Route::post('/insert',[AdminController::class,'insert']);
    Route::get('/delete/{id}',[AdminController::class,'delete'])->name('delete');
    Route::get('/change/{id}',[AdminController::class,'change'])->name('change');
    Route::get('/edit/{id}',[AdminController::class,'edit'])->name('edit');
    Route::put('/update/{id}',[AdminController::class,'update'])->name('update');
    Route::post('/image/delete/{id}', [AdminController::class, 'deleteImage'])->name('image.delete');
});
Auth::routes();

Route::get('about',[AdminController::class,'about'])->name('about');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
