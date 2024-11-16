<?php

namespace Database\Seeders;

use App\Models\Champion;
use App\Services\DataDragonService;
use App\Traits\TracksProgress;
use Illuminate\Database\Seeder;

class ChampionSeeder extends Seeder
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
        Champion::query()->delete();

        $championCount = $this->dataDragonService->getChampionCount();
        $progressBar = $this->createProgressBar($championCount);

        // Load the champions
        $this->dataDragonService->updateChampions(function () use ($progressBar) {
            $progressBar->advance();
        });

        $this->finishProgressBar($progressBar);
    }
}
