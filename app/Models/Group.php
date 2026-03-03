<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $table = 'groups';
    protected $fillable = [
        'name',
        'level',
        'amount',
        'teacher_id',
        'course_id',
        'room_id',
        'days',
        'percent',
        'starts_at',
        'ends_at',
        'status',
    ];

    public function teacher(){
        return $this->belongsTo(User::class,'teacher_id');
    }

    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }

    public function room(){
        return $this->belongsTo(Room::class,'room_id');
    }
}
