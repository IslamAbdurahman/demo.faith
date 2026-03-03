<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $table = 'payments';
    protected $fillable = [
        'month',
        'amount',
        'kitchen',
        'bedroom',
        'education',
        'comment',
        'user_id',
        'graphic_id',
        'student_id',
        'kassa_id',
        'transaction_id',
        'date',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function graphic(){
        return $this->belongsTo(Graphic::class,'graphic_id')->with([
            'group'
        ]);
    }
    public function student(){
        return $this->belongsTo(Students::class,'student_id');
    }
    public function kassa(){
        return $this->belongsTo(Kassa::class,'kassa_id');
    }
}
