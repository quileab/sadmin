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

// funciona bien pero... ( $id a traves de __CONSTRUCT )
// Route::middleware(['auth:sanctum', 'verified'])->get('/subjects/{career_id}', function ($career_id) {
//     return view('subjects.index',['career_id'=>$career_id]);
// })->name('subjects');

// Route::middleware(['auth:sanctum', 'verified'])->get('/subjects/{id}', [\App\Http\Livewire\SubjectsComponent::class, [$career_id=>$id]])->name('subjects');

// lo de abajo es un FullPage Livewire -> funciona a medias a través del MOUNT
Route::middleware(['auth:sanctum', 'verified'])->get('/subjects/{career_id}', \App\Http\Livewire\SubjectsComponent::class)->name('subjects');
