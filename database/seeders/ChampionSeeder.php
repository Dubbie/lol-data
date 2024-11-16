<?php

namespace Database\Seeders;

use App\Models\Champion;
use App\Services\DataDragonService;
use Illuminate\Database\Seeder;

class ChampionSeeder extends Seeder
{
    private DataDragonService $dataDragonService;

    public function __construct(DataDragonService $dataDragonService)
    {
        $this->dataDragonService = $dataDragonService;
        $this->dataDragonService->updateVersion();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Champion::query()->delete();

        // Load the champions
        $this->dataDragonService->updateChampions();
    }
}
