<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\LanguageController;
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

Route::get('/', function () {
    return redirect('login');
});
Route::get('change-language/{locale}', [LanguageController::class, 'change'])->name('language.change');

Auth::routes();

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin::', 'middleware' => 'auth'], function () {
    /**
     * Requires authentication.
     */
    Route::get('/', [DashboardController::class, 'index'])->name('home');
});
