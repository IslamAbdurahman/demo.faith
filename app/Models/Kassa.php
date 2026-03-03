<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kassa extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $table = 'kassa';
    protected $fillable = [
        'name',
        'balance',
        'is_cash',
        'is_click',
    ];
}
