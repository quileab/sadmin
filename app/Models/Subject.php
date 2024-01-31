<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function career() {
        return $this->belongsTo('App\Models\Career');
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    // return array of students in Grades table for this subject and date='2000-01-01'
    // order by lastname and firstname 
    public function students(){
        $dateFrom=date('Y-m-d', strtotime(session('cycle').'-01-01'));
        $dateTo=date('Y-m-d', strtotime(session('cycle').'-12-31'));

        $students = \App\Models\User::join('grades', 'users.id', '=', 'grades.user_id')
        ->where('grades.subject_id', $this->id)
        ->where('grades.date_id', '2000-01-01')
        ->whereBetween('grades.updated_at', [$dateFrom, $dateTo])
        ->orderBy('lastname','ASC')
        ->orderBy('firstname','ASC')
        ->role('student')
        ->get();
        return $students;
    }

    public function grades() {
        return $this->hasMany(Grade::class);
    }
    public function Correlativities(string $type="exam"){
        $equiv=['exam'=>1,'course'=>0];
        //split correls into course / exams
        $correl=explode('/',$this->correl);
        if (count($correl)!=2){ // wrong format string correl
            return [];
        }        
        // subdivide courses and exams
        $subjects_ids= array_filter( preg_split("/[\s,]+/", $correl[$equiv[$type]]) );
        return Subject::whereIn('id', $subjects_ids)->get(['id','name'])
            ->pluck('name', 'id')->all();
    }

    public static function classes($subject_id) {
        $dateFrom=date('Y-m-d', strtotime(session('cycle').'-01-01'));
        $dateTo=date('Y-m-d', strtotime(session('cycle').'-12-31'));

        return Classbook::where('subject_id', $subject_id)
            ->whereBetween('date_id', [$dateFrom, $dateTo])
            ->get();
    }

    public static function getClass($subject_id,$date_id){
        return Classbook::where('subject_id', $subject_id)
            ->where('date_id', $date_id)
            ->first();
    }
}
