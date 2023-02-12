<?php

use App\Http\Controllers\ListController;
use App\Http\Controllers\UserController;
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

Route::get('/', function (){
    return redirect('lists');
});

Route::resource('lists',ListController::class)->middleware('auth');

Route::post('lists/delete/article', [ListController::class, 'deleteArticle'])->middleware('auth');
Route::post('lists/delete/article/image', [ListController::class, 'deleteImage'])->middleware('auth');

Route::name('user.')->group(function () {
    Route::controller(UserController::class)->group(function () {
        //регистрация
        Route::get('/registration', 'showRegistrationView')->name('showRegistrationView');
        Route::post('/registration', 'register')->name('register');
        //авторизация
        Route::get('/login', 'showLoginView')->name('showLoginView');
        Route::post('/login', 'login')->name('login');
        //выход
        Route::get('/logout', 'logout')->name('logout');
    });
});
