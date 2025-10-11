<?php

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\postJson;

it('can login as guest', function () {
    postJson(route('api.auth.login-guest'))
        ->assertOk()
        ->assertSee('accessToken');

    assertDatabaseCount('users', 1);
});
