<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    // protected $fillable = ['id','name','correl','user_id'];
    protected $guarded = [];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function subjects(){
        return $this->hasMany('App\Models\Subject');
    }
}
