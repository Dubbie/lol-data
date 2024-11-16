<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Champion extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'inner_name';

    protected $fillable = [
        'inner_name',
        'name',
        'title',
        'splash_image',
        'square_image',
        'patch_version'
    ];

    protected $with = ['passive'];

    public function passive()
    {
        return $this->hasOne(ChampionPassive::class, 'champion_name', 'inner_name');
    }
}
