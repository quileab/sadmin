<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'user_id';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
