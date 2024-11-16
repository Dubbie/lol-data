<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChampionSpell extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'champion_name',
        'description',
        'effect_burn',
        'tooltip',
        'image',
        'priority',
        'cooldown'
    ];

    protected $casts = [
        'effect_burn' => 'array',
        'cooldown' => 'array'
    ];

    public function champion()
    {
        return $this->belongsTo(Champion::class, 'champion_name', 'inner_name');
    }
}
