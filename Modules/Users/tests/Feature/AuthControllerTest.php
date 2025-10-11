<?php

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\postJson;

it('can login as guest', function () {
    postJson(
        route('api.auth.login-guest'),
        headers: [
            'X-Public-Token' => config('auth.public-token'),
        ],
    )
        ->assertOk()
        ->assertSee('accessToken');

    assertDatabaseCount('users', 1);
});
