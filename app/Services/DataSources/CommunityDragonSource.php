<?php

namespace App\Services\DataSources;

use App\Contracts\ChampionDataSource;
use App\Models\Champion;
use App\Models\ChampionPassive;
use App\Models\ChampionSpell;

class CommunityDragonSource implements ChampionDataSource
{
    private string $url = "https://raw.communitydragon.org/json";

    public function updateChampions(callable $progressCallback = null): array
    {
        $files = $this->getChampionFiles();

        // Go through the files, and create the champions based on it.
        $champions = [];

        foreach ($files as $fileData) {
            // Skip the -1.json as it's useless
            if ($fileData['name'] === '-1.json') {
                continue;
            }

            $fileUrl = sprintf('%s/latest/plugins/rcp-be-lol-game-data/global/default/v1/champions/%s', $this->url, $fileData['name']);

            $champData = json_decode(file_get_contents($fileUrl), true);

            $champion = Champion::updateOrCreate([
                'inner_name' => $champData['alias'],
                'name' => $champData['name'],
                'title' => $champData['title'],
                'splash_image' => $this->mapAsset($champData['skins'][0]['splashPath']),
                'square_image' => $this->mapAsset($champData['skins'][0]['tilePath']),
                'patch_version' => 'latest'
            ]);

            // Update the spells here too.
            $this->updateSpells($champData);

            if ($progressCallback) {
                $progressCallback();
            }

            $champions[] = $champion;
        }

        return $champions;
    }

    public function getChampionCount(): int
    {
        return count($this->getChampionFiles()) - 1;
    }

    private function getChampionFiles()
    {

        $championFiles = sprintf('%s/latest/plugins/rcp-be-lol-game-data/global/default/v1/champions', $this->url);

        $files = json_decode(file_get_contents($championFiles), true);

        return $files;
    }

    private function updateSpells(array $champData)
    {
        // Update the passive
        ChampionPassive::updateOrCreate([
            'name' => $champData['passive']['name']
        ], [
            'description' => $champData['passive']['description'],
            'image' => $this->mapAsset($champData['passive']['abilityIconPath']),
            'champion_name' => $champData['alias']
        ]);

        // Update the spells
        foreach ($champData['spells'] as $index => $spellData) {
            ChampionSpell::updateOrCreate([
                'id' => $spellData['name'],
                'name' => $spellData['name'],
                'description' => $spellData['description'],
                'tooltip' => $spellData['dynamicDescription'],
                'cost_coefficients' => $spellData['costCoefficients'],
                'cooldown_coefficients' => $spellData['cooldownCoefficients'],
                'coefficients' => $spellData['coefficients'],
                'effect_amounts' => $spellData['effectAmounts'],
                'spell_key' => $spellData['spellKey'],
                'priority' => $index,
                'image' => $this->mapAsset($spellData['abilityIconPath']),
                'champion_name' => $champData['alias'],
            ]);
        }
    }

    private function mapAsset(string $path)
    {
        // "/lol-game-data/assets/<path>"
        // Should map to
        // "/plugins/rcp-be-lol-game-data/global/default/<lowercased-path>"
        $replacedPath = str_replace('/lol-game-data/assets/', '', $path);
        $replacedPath = mb_strtolower($replacedPath);

        return sprintf('%s/latest/plugins/rcp-be-lol-game-data/global/default/%s', $this->url, $replacedPath);
    }
}
