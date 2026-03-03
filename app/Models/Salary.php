<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $table = 'salaries';
    protected $fillable = [
        'personal',
        'worker_id',
        'amount',
        'user_id',
        'kassa_id',
        'date',
        'comment',
    ];

    public function worker(){
        return $this->belongsTo(User::class,'worker_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function kassa(){
        return $this->belongsTo(Kassa::class,'kassa_id');
    }
}
