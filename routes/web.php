<?php

use App\Http\Controllers\PrintInscriptionsController;
use App\Http\Controllers\PrivateFilesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PrintClassbookController;
use App\Http\Controllers\PrintStudentsStatsController;
use App\Models\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    // $info=\App\Models\Config::find('shortname')->value.
    //   ' '.\App\Models\Config::find('longname')->value;
    //return view('welcome',compact('info'));

    return redirect()->route('login');
});
Route::get('/register', function () {
    return redirect()->route('login');
});

Route::get('/previewReceipt', function () {
    return view('pdf.paymentReceipt');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/clear', function () {
        if (! auth()->user()->hasRole('admin')) {
            return abort(404);
        }
        $logs = [];
        $maintenance=[
            'Cache'=>'cache:clear',
            'Config'=>'config:clear',
            'Optimize Clear'=>'optimize:clear',
            'Optimize'=>'optimize',
            'DebugBar'=>'debugbar:clear',
            'Storage Link'=>'storage:link',
            'Route Clear'=>'route:clear',
        ];
        foreach ($maintenance as $key => $value) {
            try {
                Artisan::call($value);
                $logs[$key]='✔️';
            } catch (\Exception $e) {
                $logs[$key]='❌';
            }
        }
        return view('clearMaintenance', compact('logs'));    
    });

    Route::get('/dashboard', function () {
        // get first record from config table
        // $temp = new NumberFormatter('es', NumberFormatter::SPELLOUT);

        $dashInfo = [
            'shortname' => Config::where('id', 'shortname')->first()->value ?? 'false',
            'longname' => Config::where('id', 'longname')->first()->value ?? 'false',
            'modalities' => Config::where('id', 'modalities')->first()->value ?? 'false',
            'careers' => Auth::user()->careers()->get(),
            'rolesUsersCount' => Auth::user()->getCountByRole(),
        ];
        $inscriptions = Config::where('group', 'inscriptions')->get()->toArray();

        // get student subjects inscriptions
        if (auth()->user()->hasRole('student')){
        $subjects=\App\Models\User::find(Auth::user()->id)->subjects()->get(['id','name','career_id'])->toArray();
        }
        else{
            $subjects=[];
        }

        return view('dashboard', compact('dashInfo', 'inscriptions','subjects'));
    })->name('dashboard');

    Route::get('PDFs/{filename}', function ($filename) {
        $path = storage_path('public/'.$filename);

        if (! File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);

        return $response;
    });

    Route::get('/files/private/{filename}', [PrivateFilesController::class, 'files']);

    Route::get('/permissions', function () {
        if (! auth()->user()->hasRole(['admin', 'principal'])) {
            return abort(404);
        }

        return view('permissions.index');
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
        if (! auth()->user()->can('menu.students')) {
            abort(404);
        }

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
        abort(404);
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
            $roles = Role::all();
            return view('students.import-form', compact('roles'));
        }
        return back();
    })->name('students-import-form');
    // IMPORT BULK
    Route::post('/students-import-bulk', [StudentController::class, 'importBulk'])->name('students-import-bulk');

    Route::get('/grades/{id}', function ($id) {
        if (auth()->user()->hasRole(['admin', 'principal', 'teacher', 'student'])) {
            return view('grades.index', compact('id'));
        }

        return back();
    })->name('grades');

    Route::get('/grades/{id}/{career}', function ($id, $career) {
        return view('grades.student', compact(['id', 'career']));
    })->name('gradesCareer');

    Route::get('/userpayments/{id}', function ($id) {
        return view('userpayments', compact('id'));
    })->name('userpayments');

    Route::get('/paymentsDetails/{id}', \App\Http\Livewire\PaymentsDetails::class)->name('paymentsDetails');

    Route::get('/calendars', function () {
        return view('calendars.index');
        // lo de abajo al no utilizar la directiva @livewire
        // no funciona por eso use el .index para llamar al componente
        // return view('livewire.calendars-component');
    })->name('calendars');

    // ruta a un FullPage Livewire -> funciona a medias a través del MOUNT // No necesita subjects.index
    Route::get('/subjects/{career_id}', \App\Http\Livewire\SubjectsComponent::class)->name('subjects');

    Route::get('/classbooks', \App\Http\Livewire\Classbooks::class)->name('classbooks');
    Route::get('/mystudents', \App\Http\Livewire\MyStudents::class)->name('mystudents');

    Route::get('/books', function () {
        return view('books');
    })->name('books');

    Route::get('/inscriptionsPDF/{student}/{career}/{inscription}', [PrintInscriptionsController::class, 'index'])->name('inscriptionsPDF');
    Route::get('/inscriptionsSavePDF/{student}/{career}/{inscription}', [PrintInscriptionsController::class, 'savePDF'])->name('inscriptionsSavePDF');

    Route::get('/teachersubjects', \App\Http\Livewire\TeacherSubjects::class)->name('teachersubjects');
    Route::get('/studentsubjects', \App\Http\Livewire\StudentSubjects::class)->name('studentsubjects');
    // TODO: quick grade component -> delete
    // Route::get('/quickgrade', \App\Http\Livewire\Quickgrade::class)->name('quickgrade');
    Route::get('/quickgrade', \App\Http\Livewire\Inscription\InscriptionsDetail::class)->name('quickgrade');
    Route::get('/printClassbooks/{subject?}', [PrintClassbookController::class,'show'])->name('printclassbooks');
    Route::get('/printStudentsAttendance/{subject}', [PrintStudentsStatsController::class,'listAttendance'])->name('printStudentsAttendance');
    Route::get('/printStudentsStats/{student}/{subject}', [PrintStudentsStatsController::class,'studentClasses'])->name('printStudentsStats');
    Route::get('/printStudentsReportCard/{student}', [PrintStudentsStatsController::class,'studentReportCard'])->name('printStudentsReportCard');
    Route::get('/debug/{student}/{subject}', [PrintStudentsStatsController::class,'debug'])->name('debug');
});
