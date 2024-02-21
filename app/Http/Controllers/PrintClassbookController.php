<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintClassbookController extends Controller
{
    function printClassbooks(Request $request, $subject=null){
        if(!$subject && !$request->subject){
            abort(404);
        }
        if(!$subject) {
            $subject=$request->subject;
        }
        $dateFrom=session('cycle').'-01-01';
        $dateTo=session('cycle').'-12-31';
 
        $config = \App\Models\Config::where('group', 'main')->get()->pluck('value', 'id')->toArray();
        $classbooks=\App\Models\Classbook::where('subject_id',$subject)
            ->whereBetween('date_id',[$dateFrom,$dateTo])
            ->get();
        $grades=\App\Models\Grade::where('subject_id',$subject)
            ->where('user_id',auth()->user()->id)
            ->whereBetween('date_id',[$dateFrom,$dateTo])
            ->get();

        // if classbooks empty, return 404
        if($classbooks->isEmpty()) {
            return back()->with('error', 'No encontrado');
        }


        // create temp array for grades and attendance
        $temp=[];
        foreach($grades as $grade) {
            $date=\Carbon\Carbon::parse($grade->date_id)->format('Y-m-d');
            $temp[$date]['attendance']=$grade->attendance;
            $temp[$date]['grade']=$grade->grade; 
        }
        $grades=$temp;

        $attendance=0; $totalAttendance=$classbooks->count()*100;
        foreach($classbooks as $classbook) {
            $classbook->attendance=$grades[$classbook->date_id]['attendance']??0;
            $classbook->grade=$grades[$classbook->date_id]['grade']??0;
            $attendance+=$classbook->attendance;
        }

        //dd($grades, $classbooks, $attendance, $totalAttendance);
        $data=[];
        $data['subject']=\App\Models\Subject::find($subject);
        $data['user']=auth()->user();
        if(auth()->user()->hasRole(['student','teacher'])) {
            $data['attendance']=number_format(100*$attendance/$totalAttendance, 2).'%';
        }

        //dd($data, $subject, $request, $request->subject);
        return view('printClassbook', compact(['classbooks','data','config']));
    }
}