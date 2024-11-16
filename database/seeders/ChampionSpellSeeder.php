<?php

namespace Database\Seeders;

use App\Models\Champion;
use App\Models\ChampionSpell;
use App\Services\DataDragonService;
use App\Traits\TracksProgress;
use Illuminate\Database\Seeder;

class ChampionSpellSeeder extends Seeder
{
    use TracksProgress;

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

        $championCount = Champion::count();
        $progressBar = $this->createProgressBar($championCount);

        $this->dataDragonService->updateChampionSpells(function () use ($progressBar) {
            $progressBar->advance();
        });

        $this->finishProgressBar($progressBar);
    }
}
