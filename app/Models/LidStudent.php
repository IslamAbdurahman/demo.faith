<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LidStudent extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'lid_students';
    protected $fillable = [
        'lid_id',
        'student_id',
        'comment'
    ];


    public function lid(){
        return $this->belongsTo(Lid::class,'lid_id');
    }

    public function student(){
        return $this->belongsTo(Students::class,'student_id');
    }
}
