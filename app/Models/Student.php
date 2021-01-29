<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'user_id';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function career(){
        return $this->hasOne('App\Models\Career');
    }
}
