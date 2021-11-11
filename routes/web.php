<?php

use App\Models\Config;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PrivateFilesController;
use App\Http\Controllers\PrintInscriptionsController;

Route::get('/', function () {
    // $info=\App\Models\Config::find('shortname')->value.
    //   ' '.\App\Models\Config::find('longname')->value;
    //return view('welcome',compact('info'));
    return redirect()->route('login');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        // get first record from config table
        $temp = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        
        $dashInfo=[
            'shortname' => Config::where('id', 'shortname')->first()->value ?? 'false',
            'longname' => Config::where('id', 'longname')->first()->value ?? 'false',
            'modalities' => Config::where('id', 'modalities')->first()->value ?? 'false',
            'careers'=>Auth::user()->careers()->get(),
            'number'=> $temp->format(Auth::user()->userCount()),
        ];
        $inscriptions= Config::where('group', 'inscriptions')->get();
        return view('dashboard',compact('dashInfo','inscriptions'));
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
        if (auth()->user()->can('menu.inscriptions')) {
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
        abort(403);
    })->name('studentsinsc');

    Route::get('/inscriptionsData/{id}', function ($id) {
        if (auth()->user()->can('menu.inscriptions')) {
            $inscription = Config::find($id) ?? [];
            if ($inscription == []) {
                return redirect()->route('studentsinsc');
            }
            return view('students.inscriptionsData', compact('inscription', 'id'));
        }
    })->name('studentsinscdata');

    // IMPORT FORM
    Route::get('/students-import-form', function () {
      if (auth()->user()->hasRole('admin')) {
          $roles=Role::all();
          return view('students.import-form', compact('roles'));
      }
      return back();
    })->name('students-import-form');
    // IMPORT BULK
    Route::post('/students-import-bulk', [StudentController::class,'importBulk'])->name('students-import-bulk');

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

    Route::get('/inscriptionsPDF/{student}/{career}/{inscription}', [PrintInscriptionsController::class,'index'])->name('inscriptionsPDF');
    Route::get('/inscriptionsSavePDF/{student}/{career}/{inscription}', [PrintInscriptionsController::class,'savePDF'])->name('inscriptionsSavePDF');
        
});