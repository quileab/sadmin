<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'uid', 'title', 'publisher', 'author',
        'gender', 'extent', 'edition', 'isbn',
        'container', 'signature', 'digital', 'origin',
        'date_added', 'price', 'discharge_date',
        'discharge_reason', 'synopsis', 'note', 'user_id'
    ];
}
