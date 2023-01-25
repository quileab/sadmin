<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classbook extends Model
{
    use HasFactory;

    // protected $fillable = ['...','...'];
    protected $guarded = [];
    protected $primaryKey = 'subject_id';
    public $incrementing = false;

    /**
     * Format date into local
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    // protected function date(): Attribute {
    //   return Attribute::make(
    //     get: fn ($value) => 
    //     \Carbon\Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y'),
    //   );
    // }

    public static function classCount(string $subject_id){
        $counts=[];
        $counts['total']=\App\Models\Classbook::where('subject_id',$subject_id)->count('subject_id');
        $counts['classes']=\App\Models\Classbook::where('subject_id',$subject_id)
            ->where('Unit','>','0')->count('subject_id');
        $counts['none']=$counts['total']-$counts['classes'];
        return $counts;
    }
}
