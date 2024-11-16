<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Champion extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'inner_name',
        'name',
        'title',
        'splash_image',
        'square_image',
        'patch_version'
    ];
}
