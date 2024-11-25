<?php

namespace App\Services;

use App\Models\Champion;
use App\Models\ChampionPassive;
use App\Models\ChampionSpell;
use Illuminate\Support\Collection;

class DataDragonService
{
    private string $url;
    private string $version;

    public function __construct()
    {
        $this->url = config('ddragon.url');

        $this->updateVersion();
    }

    public function updateVersion()
    {
        $versionsUrl = sprintf('%s/api/versions.json', $this->url);

        $data = json_decode(file_get_contents($versionsUrl), true);
        $this->version = $data[0];
    }

    public function getChampionData(): array
    {
        $championsUrl = sprintf('%s/cdn/%s/data/en_US/champion.json', $this->url, $this->version);
        $data = json_decode(file_get_contents($championsUrl), true);

        return $data['data'];
    }

    public function getChampionCount(): int
    {
        return count($this->getChampionData());
    }

    public function updateChampions(callable $progressCallback = null)
    {
        $championsData = $this->getChampionData();

        foreach ($championsData as $innerName => $champData) {
            Champion::updateOrCreate(
                ['inner_name' => $innerName],
                [
                    'name' => $champData['name'],
                    'title' => $champData['title'],
                    'splash_image' => sprintf('%s/cdn/img/champion/splash/%s_0.jpg', $this->url, $innerName),
                    'square_image' => sprintf('%s/cdn/%s/img/champion/%s', $this->url, $this->version, $champData['image']['full']),
                    'patch_version' => $champData['version'],
                ]
            );

            if ($progressCallback) {
                $progressCallback();
            }
        }
    }

    public function updateChampionSpells(callable $progressCallback = null)
    {
        $championNames = Champion::get('inner_name')->pluck('inner_name')->toArray();

        foreach ($championNames as $name) {
            $dataUrl = sprintf('%s/cdn/%s/data/en_US/champion/%s.json', $this->url, $this->version, $name);
            $champData = json_decode(file_get_contents($dataUrl), true);
            $data = $champData['data'][$name];

            $this->updatePassive($name, $data['passive']);
            $this->updateSpells($name, $data['spells']);

            // Call the progress callback, if provided
            if ($progressCallback) {
                $progressCallback();
            }
        }
    }

    private function updatePassive(string $name, array $passiveData): ChampionPassive
    {
        $passive = ChampionPassive::updateOrCreate([
            'name' => $passiveData['name']
        ], [
            'champion_name' => $name,
            'description' => $passiveData['description'],
            'image' => sprintf('%s/cdn/%s/img/passive/%s', $this->url, $this->version, $passiveData['image']['full'])
        ]);

        return $passive;
    }

    private function updateSpells(string $name, array $spellsData): Collection
    {
        $spells = new Collection();

        foreach ($spellsData as $index => $spellData) {
            $spell = ChampionSpell::updateOrCreate([
                'id' => $spellData['id'],
            ], [
                'name' => $spellData['name'],
                'description' => $spellData['description'],
                'tooltip' => $spellData['tooltip'],
                'effect_burn' => $spellData['effectBurn'],
                'cooldown' => $spellData['cooldown'],
                'champion_name' => $name,
                'image' => sprintf('%s/cdn/%s/img/spell/%s', $this->url, $this->version, $spellData['image']['full']),
                'priority' => $index,
            ]);

            $spells->push($spell);
        }

        return $spells;
    }
}
