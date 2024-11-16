<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChampionSpell extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id',
        'champion_name',
        'description',
        'tooltip',
        'image',
    ];
}
