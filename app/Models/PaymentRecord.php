<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    protected $fillable = [
        'user_id',
        'userpayments_id',
        'paymentBox',
        'description',
        'paimentAmount',
    ];

    protected $table = "paymentrecords";
    use HasFactory;
}
