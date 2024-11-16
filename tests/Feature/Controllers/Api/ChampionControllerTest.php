<?php

use App\Models\Champion;

test('champions load without params', function () {
    $response = $this->get(route('api.champion.index'));

    $response->assertStatus(200);
});

test('champions load with params', function () {
    $response = $this->get(route('api.champion.index', [
        'query' => 'Amumu'
    ]));

    $response->assertStatus(200);
});

test('champions return based on query', function () {
    Champion::factory()->create([
        'name' => 'Amumu'
    ]);

    $response = $this->get(route('api.champion.index', [
        'query' => 'Amumu'
    ]));

    $response->assertStatus(200)->assertJsonCount(1)->assertJsonFragment(['name' => 'Amumu']);
});
