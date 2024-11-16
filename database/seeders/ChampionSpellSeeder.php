<?php

namespace Database\Seeders;

use App\Models\ChampionSpell;
use App\Services\DataDragonService;
use Illuminate\Database\Seeder;

class ChampionSpellSeeder extends Seeder
{
    private DataDragonService $dataDragonService;

    public function __construct(DataDragonService $dataDragonService)
    {
        $this->dataDragonService = $dataDragonService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChampionSpell::query()->delete();

        $this->dataDragonService->updateChampionSpells();
    }
}
