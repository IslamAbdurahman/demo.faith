<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $table = 'student_groups';
    protected $fillable = [
        'student_id',
        'group_id',
        'date'
    ];

    public function student(){
        return $this->belongsTo(Students::class,'student_id');
    }
    public function group(){
        return $this->belongsTo(Group::class,'group_id');
    }
}
