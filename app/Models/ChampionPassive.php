<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChampionPassive extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'name';

    protected $fillable = [
        'champion_name',
        'name',
        'description'
    ];

    public function champion()
    {
        return $this->belongsTo(Champion::class, 'champion_name', 'inner_name');
    }
}
