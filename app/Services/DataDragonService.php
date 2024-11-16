<?php

namespace App\Services;

use App\Models\Champion;

class DataDragonService
{
    private string $url;
    private string $version;

    public function __construct()
    {
        $this->url = config('ddragon.url');
    }

    public function updateVersion()
    {
        $versionsUrl = sprintf('%s/api/versions.json', $this->url);

        $data = json_decode(file_get_contents($versionsUrl), true);
        $this->version = $data[0];
    }

    public function updateChampions()
    {
        $championsUrl = sprintf('%s/cdn/%s/data/en_US/champion.json', $this->url, $this->version);

        $data = json_decode(file_get_contents($championsUrl), true);
        $championsData = $data['data'];

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
        }
    }
}
