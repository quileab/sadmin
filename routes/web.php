<?php

use App\Models\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PrintInscriptionsController;
use App\Http\Controllers\PrivateFilesController;
use App\Models\Studentinscription;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        // get first record from config table
        $temp = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        
        $dashInfo=[
            'shortname' => Config::where('id', 'shortname')->first()->value ?? 'false',
            'longname' => Config::where('id', 'longname')->first()->value ?? 'false',
            'inscriptions' => Config::where('id', 'inscriptions')->first()->value ?? 'false',
            'modalities' => Config::where('id', 'modalities')->first()->value ?? 'false',
            'exams' => Config::where('id', 'exams')->first()->value ?? 'false',
            'careers'=>Auth::user()->careers()->get(),
            'number'=> $temp->format(Auth::user()->userCount()),
        ];
        return view('dashboard',compact('dashInfo'));
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

    Route::get('/files/private/{filename}', [PrivateFilesController::class, 'files']);
  
    Route::get('/permissions', function () {
        if (auth()->user()->can('menu.security')) {
            return view('permissions.index');
        }
        return abort(403);
    })->name('permissions');

    Route::get('/assignrole/{id}', function ($id) {
        return view('permissions.assignroles', compact('id'));
    })->name('assignroles');

    Route::get('/configs', function () {
        return view('configs.index');
    })->name('configs');

    Route::get('/infocards', function () {
        return view('infocards.index');
    })->name('infocards');

    Route::get('/careers', function () {
        return view('careers.index');
    })->name('careers');

    Route::get('/students', function () {
        return view('students.index');
    })->name('students');

    Route::get('/payplans', function () {
        return view('payplans');
    })->name('payplans');

    Route::get('/inscriptions', function () {
        if (auth()->user()->can('menu.exams')) {
            // busca en config las inscripciones que el ID NO terminen "-data"
            $inscriptions = Config::where('group', 'inscriptions')->where('id', 'not like', '%-data')->get();
            if (auth()->user()->hasRole('student')) {
                $careers = auth::user()->careers()->get();
                if ($careers->count() == 0) {
                    $inscriptions = [];
                }
            }
            return view('students.inscriptions', compact('inscriptions'));
        } 
    })->name('studentsinsc');

    Route::get('/inscriptionsData/{id}', function ($id) {
        if (auth()->user()->can('menu.exams')) {
            $inscription = Config::find($id) ?? [];
            if ($inscription == []) {
                return redirect()->route('studentsinsc');
            }
            return view('students.inscriptionsData', compact('inscription'));
        }
    })->name('studentsinscdata');

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

    Route::get('/userpayments/{id}', function ($id) {
        return view('userpayments',compact('id'));
    })->name('userpayments');

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

    Route::get('/inscriptionsPDF/{student}/{career}', [PrintInscriptionsController::class,'index'])->name('inscriptionsPDF');
    
    Route::get('/inscriptionsSavePDF/{student}/{career}', [PrintInscriptionsController::class,'savePDF'])->name('inscriptionsSavePDF');
        
});

/*

// funciona bien pero... // Aclaracion -> $id a traves de __CONSTRUCT 
// Route::middleware(['auth:sanctum', 'verified'])->get('/subjects/{career_id}', function ($career_id) {
//     return view('subjects.index',['career_id'=>$career_id]);
// })->name('subjects');

*/
