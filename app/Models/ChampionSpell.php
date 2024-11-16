<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChampionSpell extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'spell_key',
        'champion_name',
        'description',
        'effect_amounts',
        'cooldown_coefficients',
        'cost_coefficients',
        'coefficients',
        'tooltip',
        'image',
        'priority',
    ];

    protected $casts = [
        'effect_amounts' => 'array',
        'cooldown_coefficients' => 'array',
        'cost_coefficients' => 'array',
        'coefficients' => 'array',
    ];

    public function champion()
    {
        return $this->belongsTo(Champion::class, 'champion_name', 'inner_name');
    }
}
