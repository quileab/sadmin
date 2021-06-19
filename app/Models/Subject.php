<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function career(){
        return $this->belongsTo('App\Models\Career');
    }

    public function grades(){
        return $this->hasMany(Grade::class);
    }
}
