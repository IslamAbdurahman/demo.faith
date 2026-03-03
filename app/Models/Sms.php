<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Sms extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table = 'sms';

    protected $fillable = [
        'student_id',
        'user_id',
        'text',
        'date',
        'service_id',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function student(){
        return $this->belongsTo(Students::class,'student_id');
    }
    public function service(){
        return $this->belongsTo(SmsService::class,'service_id');
    }


}
