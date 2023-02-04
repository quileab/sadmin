<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintStudentsStatsController extends Controller
{
    private $subject;

    function listAttendance(Request $request, $subject){
        $this->subject = $subject;
        $config = \App\Models\Config::where('group', 'main')->get()->pluck('value', 'id')->toArray();
        $classCount=\App\Models\Classbook::where('subject_id',$subject)
            ->where('Unit','>',0)
            ->count();
        $classCount=$classCount;
        $data=[];
        $data['subject']=\App\Models\Subject::find($subject);
        $data['user']=auth()->user();
        $students = \App\Models\User::orderBy('lastname','ASC')
            ->orderBy('firstname','ASC')
            ->whereHas('subjects', function ($query) {
                $query->where('subjects.id', $this->subject);
            })
            ->role('student')
            ->get();

        foreach ($students as $student) {
            $student->attendance=\App\Models\Grade::
                where('user_id',$student->id)
                ->where('subject_id',$this->subject)
                ->sum('attendance');
            $student->attendance=ceil($student->attendance/$classCount);
        }

        return view('printStudentsStats', compact(['classCount','students','data','config']));
    }
}
