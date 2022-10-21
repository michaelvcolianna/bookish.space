<?php

use App\Http\Livewire\Projects\Listing as ListProjects;
use App\Http\Livewire\Projects\View as ViewProject;
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

Route::view('/', 'welcome')->name('welcome');

$middleware = ['auth:sanctum', config('jetstream.auth_session'), 'verified'];
Route::middleware($middleware)->group(function() {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::group(['as' => 'projects.', 'prefix' => 'projects'], function() {
        Route::get('/', ListProjects::class)->name('listing');
        Route::get('/{handle}/{slug}', ViewProject::class)->name('view');
    });
});
