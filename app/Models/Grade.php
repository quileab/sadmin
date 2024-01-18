<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    //protected $primaryKey = ['user_id','subject_id','date_id'];
    protected $primaryKey = 'user_id';
    protected $guarded = [];

    protected function setKeysForSaveQuery($query){
        //$date_id = \Carbon\Carbon::createFromFormat('d-m-Y', $this->getAttribute('date_id'))->format('Y-m-d');
        $query->where('user_id', $this->getAttribute('user_id'))
            ->where('subject_id', $this->getAttribute('subject_id'))
            ->whereDate('date_id', $this->getAttribute('date_id'));
            //->whereDate('date_id', $date_id);
        return $query;
    }

    public function subject() {
        return $this->belongsTo('App\Models\Subject');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function getDateIdAttribute() {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $this->attributes['date_id'])->format('d-m-Y');
    }
}
