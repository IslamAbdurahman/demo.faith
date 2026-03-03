<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lid extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'lids';
    protected $fillable = [
      'name'
    ];
}
