<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $table = 'students';
    protected $fillable = [
        'name',
        'gender',
        'bith_date',
        'phone',
        'parent_phone',
        'kitchen',
        'bedroom',
        'discount_education',
        'discount_kitchen',
        'discount_bedroom',
    ];
}
