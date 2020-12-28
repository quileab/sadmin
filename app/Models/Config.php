<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    //protected $fillable = ['id','group','description','value'];
    protected $guarded = [];
    public $incrementing = false; // evita que el ID al "no ser" autoincrementable mantenga su valor 
}
