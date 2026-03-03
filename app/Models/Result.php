<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $table = 'results';
    protected $fillable = [
        'test_id',
        'student_id',
        'result'
    ];
    public function test(){
        return $this->belongsTo(Test::class,'test_id');
    }
    public function student(){
        return $this->belongsTo(Students::class,'student_id');
    }
}
