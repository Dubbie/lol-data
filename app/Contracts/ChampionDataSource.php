<?php

namespace App\Contracts;

interface ChampionDataSource
{
    public function updateChampions(): array;
    public function getChampionCount(): int;
}
