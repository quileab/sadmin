<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;

class PrintInscriptionsController extends Controller
{
    public function index($student_id,Career $career){
        $inscriptions = \App\Models\Studentinscription::where('user_id', $student_id)->get();
        //dd($inscriptions);
        // this enables static method calls on the PDF class
        $pdf=app('dompdf.wrapper');
        $pdf->loadView('inscriptionsPDF', compact('inscriptions','career'));
        return $pdf->stream("insc-$student_id.pdf");
    }
}
