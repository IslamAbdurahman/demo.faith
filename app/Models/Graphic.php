<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graphic extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $table = 'graphics';
    protected $fillable = [
        'month',
        'amount',
        'paid_amount',
        'remaining_amount',
        'education',
        'kitchen',
        'bedroom',
        'student_id',
        'group_id'
    ];

    public function student(){
        return $this->belongsTo(Students::class,'student_id');
    }

    public function group(){
        return $this->belongsTo(Group::class,'group_id')->with([
            'teacher'
        ]);
    }

}
