<?php

namespace Database\Seeders;

use App\Models\Champion;
use App\Services\DataSources\CommunityDragonSource;
use App\Traits\TracksProgress;
use Illuminate\Database\Seeder;

class ChampionSeeder extends Seeder
{
    use TracksProgress;

    private CommunityDragonSource $source;

    public function __construct(CommunityDragonSource $source)
    {
        $this->source = $source;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Champion::query()->delete();

        $championCount = $this->source->getChampionCount();
        $progressBar = $this->createProgressBar($championCount);

        // Load the champions
        $this->source->updateChampions(function () use ($progressBar) {
            $progressBar->advance();
        });

        $this->finishProgressBar($progressBar);
    }
}
