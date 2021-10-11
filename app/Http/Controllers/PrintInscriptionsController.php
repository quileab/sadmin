<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PrintInscriptionsController extends Controller
{

    public $config,$inscriptions;

    public function __construct()
    { // Constructor, obtengo de la configuracion los datos del
      //  grupo MAIN en forma de array asociativo ID => VALOR en This->Config
      // obtengo datos del grupo MAIN
      $this->config = \App\Models\Config::where('group','main')->get()->pluck('value','id')->toArray();
      // agrego a config datos del grupo INSCRIPTIONS
      $this->config += \App\Models\Config::where('group','inscriptions')->get()->pluck('description','id')->toArray();
    }

    public function index(User $student,Career $career, String $insc_conf_id){
        $inscriptions = \App\Models\Studentinscription::
              where('user_id', $student->id)
            ->where('name', $insc_conf_id)->get();
        $config=$this->config;
        
        //dd($inscriptions,$config);
        // this enables static method calls on the PDF class
        $pdf=app('dompdf.wrapper');
        $pdf->loadView('inscriptionsPDF',
            compact('inscriptions','student','career','config','insc_conf_id'));
        return $pdf->stream("preview.pdf");
    }

    public function savePDF(User $student,Career $career, String $insc_conf_id){
        $inscriptions = \App\Models\Studentinscription::where('user_id', $student->id)->get();
        $config=$this->config;
        // this enables static method calls on the PDF class
        $pdf=app('dompdf.wrapper');
        $pdf->loadView('inscriptionsPDF',
            compact('inscriptions','student','career','config','insc_conf_id'));
        $content = $pdf->download()->getOriginalContent();
        Storage::put("private/inscriptions/insc-$student->id-$career->id-$insc_conf_id-.pdf", $content);
        return back()->with('success', 'Inscripción guardada con éxito');
    }
}
