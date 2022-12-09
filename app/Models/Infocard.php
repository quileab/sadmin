<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infocard extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'text', 'type', 'user_id'];

    public function user()
    {
        /*** Metodo largo ***/
        // $user=User::find($this->user_id);
        // return $user;

        return $this->belongsTo('App\Models\User');
    }
}
