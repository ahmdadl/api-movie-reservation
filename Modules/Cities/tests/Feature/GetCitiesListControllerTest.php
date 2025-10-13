<?php

use Modules\Cities\Models\City;

use function Pest\Laravel\getJson;

it('should return a list of active cities', function () {
    City::factory()->count(5)->create();
    City::factory()
        ->count(5)
        ->create([
            'is_active' => false,
        ]);

    getJson(route('api.cities.index'), [...getPublicToke()])
        ->assertOk()
        ->assertJsonCount(5, 'data.records');
});
