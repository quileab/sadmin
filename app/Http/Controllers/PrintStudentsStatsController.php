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

        return view('printStudentsAttendance', compact(['classCount','students','data','config']));
    }

    function studentClasses($student,$subject){
        $this->subject = $subject;
        $data=[];
        $data['classCount']=\App\Models\Classbook::where('subject_id',$subject)
            ->where('Unit','>',0)
            ->count();
        $data['config'] = \App\Models\Config::where('group', 'main')->get()->pluck('value', 'id')->toArray();
        
        $classes=\App\Models\Grade::where('user_id',$student)
            ->where('subject_id',$subject)
            ->orderBy('date_id','ASC')->get();
        
        // calculate sums and add attibutes
        $sum_att=0; $sum_EV=0; $sum_TP=0;
        $count_EV=0; $count_TP=0;
        $attendance=0;
        foreach ($classes as $class) {
            $attendance+=$class->attendance;
            $type=substr(mb_strtoupper($class->name),0,2);
            switch ($type){
                case 'EV': 
                    $count_EV++; $sum_EV+=$class->grade;
                    $class->type = 'EV';
                break;
                case 'TP':
                    $count_TP++; $sum_TP+=$class->grade;
                    $class->type = 'TP';
                break;
                default:
                    $class->type = '';
            }
            $class->type=$type;
        }
        $data['countEV']=$count_EV; $data['countTP']=$count_TP;
        $data['sumEV']=$sum_EV; $data['sumTP']=$sum_TP;
        $data['sumAttendance']=$attendance;
        $student=\App\Models\User::find($student);
        $subject=\App\Models\Subject::find($subject);

        //dd($student, $subject, $classes);
        return view('printStudentsStats', compact(['classes','student','subject','data']));
    }
}
