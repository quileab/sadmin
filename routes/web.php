<?php

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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/infocards', function () {
    return view('infocards.index');
})->name('infocards');

Route::middleware(['auth:sanctum', 'verified'])->get('/configs', function () {
    return view('configs.index');
})->name('configs');

Route::middleware(['auth:sanctum', 'verified'])->get('/careers', function () {
    return view('careers.index');
})->name('careers');
