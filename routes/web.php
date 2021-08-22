<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\StudentController;
use App\Models\Config;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        // get first record from config table
        $shortname = Config::where('id', 'shortname')->first()->value ?? 'false';
        $longname = Config::where('id', 'longname')->first()->value ?? 'false';
        $institution = $shortname.' '.$longname;
        $inscriptions = Config::where('id', 'inscriptions')->first()->value ?? 'false';
        $modalities = Config::where('id', 'modalities')->first()->value ?? 'false';
        $exams = Config::where('id', 'exams')->first()->value ?? 'false';

        // dd($institution, $inscriptions);
        return view('dashboard',compact('institution', 'inscriptions', 'modalities','exams'));
    })->name('dashboard');

    Route::get('PDFs/{filename}', function ($filename)
    {
        $path = storage_path('public/' . $filename);
    
        if (!File::exists($path)) {
            abort(404);
        }
    
        $file = File::get($path);
        $type = File::mimeType($path);
    
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
    
        return $response;
    });


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

    Route::get('/payplans', function () {
        return view('payplans');
    })->name('payplans');

    Route::get('/exams', function () {
        return view('exams.index');
    })->name('exams');

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

    Route::get('/calendars', function () {
        return view('calendars.index');
        // lo de abajo al no utilizar la directiva @livewire
        // no funciona por eso use el .index para llamar al componente
        // return view('livewire.calendars-component');
    })->name('calendars');

    // ruta a un FullPage Livewire -> funciona a medias a través del MOUNT // No necesita subjects.index
    Route::get('/subjects/{career_id}', \App\Http\Livewire\SubjectsComponent::class)->name('subjects');

    Route::get('/books', function () {
        return view('books');
    })->name('books');

        
});

/*

// funciona bien pero... // Aclaracion -> $id a traves de __CONSTRUCT 
// Route::middleware(['auth:sanctum', 'verified'])->get('/subjects/{career_id}', function ($career_id) {
//     return view('subjects.index',['career_id'=>$career_id]);
// })->name('subjects');

*/
