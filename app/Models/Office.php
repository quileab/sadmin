<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['title', 'description', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
