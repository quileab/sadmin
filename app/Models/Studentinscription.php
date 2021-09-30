<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studentinscription extends Model
{
    use HasFactory;
    protected $primaryKey = ['user_id', 'subject_id'];
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'subject_id',
        'name',
        'type',
        'value',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function subject(){
        return $this->belongsTo('App\Models\Subject');
    }

    //protected function setKeysForSaveQuery(Builder $query)
    protected function setKeysForSaveQuery($query)
    {
        return $query->where('user_id', $this->getAttribute('user_id'))
            ->where('subject_id', $this->getAttribute('subject_id'));
    }

}
