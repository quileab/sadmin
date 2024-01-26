<?php

namespace App\Models;

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

    public function userHistory($user_id)
    {
        //return from Grades table records where user_id and all subjects from career
        return \App\Models\Grade::where('user_id', $user_id)
            ->where('grade', '>', 0)
            ->whereIn('subject_id', $this->subjects->pluck('id'))
            ->orderBy('subject_id')
            ->orderBy('date_id', 'asc');   
    }

            
}
