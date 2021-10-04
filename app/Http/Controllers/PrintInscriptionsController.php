<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PrintInscriptionsController extends Controller
{
    public function index(User $student,Career $career){
        $inscriptions = \App\Models\Studentinscription::where('user_id', $student->id)->get();
        //dd($inscriptions);
        // this enables static method calls on the PDF class
        $pdf=app('dompdf.wrapper');
        $pdf->loadView('inscriptionsPDF', compact('inscriptions','student','career'));
        return $pdf->stream("preview.pdf");
    }

    public function savePDF(User $student,Career $career){
        $inscriptions = \App\Models\Studentinscription::where('user_id', $student->id)->get();
        // this enables static method calls on the PDF class
        $pdf=app('dompdf.wrapper');
        $pdf->loadView('inscriptionsPDF', compact('inscriptions','student','career'));
        $content = $pdf->download()->getOriginalContent();
        Storage::put("private/inscriptions/insc-$student->id-$career->id-.pdf", $content);
        return back()->with('success', 'Inscripción guardada con éxito');
    }
}
