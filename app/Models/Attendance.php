<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'attendances';

    protected $fillable = [
        'student_id',
        'group_id',
        'date',
        'status'
    ];

    public function student(){
        return $this->belongsTo(Students::class,'student_id');
    }

    public function group(){
        return $this->belongsTo(Group::class,'group_id');
    }
}
