<?php

use App\Http\Controllers\StudentController;
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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/infocards', function () {
        return view('infocards.index');
    })->name('infocards');

    Route::get('/configs', function () {
        return view('configs.index');
    })->name('configs');

    Route::get('/careers', function () {
        return view('careers.index');
    })->name('careers');

    Route::get('/students', function () {
        return view('students.index');
    })->name('students');

    Route::get('/students-import-form', function () {
        return view('students.import-form');
    })->name('students-import-form');

    // *** Route to a Controller ***
    Route::post('/students-import-bulk', [StudentController::class,'importBulk'])->name('students-import-bulk');
    // *** Route to a View ***
    // Route::post('/students-import-bulk', function () {
    //     return view('students.import-bulk');
    // })->name('students-import-bulk');

    Route::get('/grades/{id}', function ($id) {
        return view('grades.index',compact('id'));
    })->name('grades');

    // ruta a un FullPage Livewire -> funciona a medias a través del MOUNT // No necesita subjects.index
    Route::get('/subjects/{career_id}', \App\Http\Livewire\SubjectsComponent::class)->name('subjects');
        
});



/*




// funciona bien pero... // Aclaracion -> $id a traves de __CONSTRUCT 
// Route::middleware(['auth:sanctum', 'verified'])->get('/subjects/{career_id}', function ($career_id) {
//     return view('subjects.index',['career_id'=>$career_id]);
// })->name('subjects');

*/