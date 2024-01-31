<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    // protected $fillable = ['id','name','correl','user_id'];
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function userHistory(Request $request, $user_id)
    {
        $dateFrom=session('cycle').'-01-01';
        $dateTo=session('cycle').'-12-31';
        dd(session('cycle'));
        //return from Grades table records where user_id and all subjects from career
        return \App\Models\Grade::where('user_id', $user_id)
            ->where('grade', '>', 0)
            ->whereBetween('date_id', [$dateFrom, $dateTo])
            ->whereIn('subject_id', $this->subjects->pluck('id'))
            ->orderBy('subject_id')
            ->orderBy('date_id', 'asc');   
    }

            
}
