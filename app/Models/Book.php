<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $appends = ['full_search'];

    protected $fillable = [
        'id', 'uid', 'title', 'publisher', 'author',
        'gender', 'extent', 'edition', 'isbn',
        'container', 'signature', 'digital', 'origin',
        'date_added', 'price', 'discharge_date',
        'discharge_reason', 'synopsis', 'note', 'user_id',
    ];

    public function user()
    {
        /** Metodo Largo */
        // $user=User::find($this->user_id);
        // return $user;
        /*** Metodo Corto */
        return $this->belongsTo('App\Models\User');
    }

    public function getFullSearchAttribute()
    {
        return $this->title.'|'.$this->author.'|'
            .$this->publisher.'|'.$this->gender.'|'
            .$this->synopsis;
    }
}
