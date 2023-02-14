<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    // protected $primaryKey = ['user_id','subject_id','date_id'];
    protected $primaryKey = 'user_id';
    protected $guarded = [];

    public function subject() {
        return $this->belongsTo('App\Models\Subject');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function getDateIdAttribute() {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $this->attributes['date_id'])->format('d-m-Y');
    }
}
