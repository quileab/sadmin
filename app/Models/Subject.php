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

    public static function classes($subject_id) {
        return Classbook::where('subject_id', $subject_id)->get();
    }

    public static function getClass($subject_id,$date_id){
        return Classbook::where('subject_id', $subject_id)
            ->where('date_id', $date_id)
            ->first();
    }
}
