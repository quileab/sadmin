<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function grades() {
        return $this->hasMany(Grade::class);
    }

    public function students($subject_id) {
        // return users_ids array where grades =0 and date=2000-01-01
        return \App\Models\Grade::join('users', 'id','=','user_id')->
            where('subject_id',$subject_id)->
            where('date_id','2000-01-01')->
            where('approved',1)->
            select(array('user_id','lastname','firstname','date_id'))->
            get();//pluck('user_id');//get(); 
    }
}
