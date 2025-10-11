<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Emails\UserRegisteredMail;
use Modules\Users\Events\UserLoginEvent;
use Modules\Users\Models\User;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\postJson;
use function Pest\Laravel\withExceptionHandling;

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

it('can not login as user without guest authed', function () {
    withExceptionHandling();

    postJson(route('api.auth.login-user'))->assertUnauthorized();
});

it('can login as user', function () {
    $user = User::factory()->createOne([
        'password' => ($password = '12312313'),
    ]);

    $guest = asTestGuest();

    postJson(route('api.auth.login-user'), [
        'email' => $user->email,
        'password' => $password,
    ])->assertOk();

    assertDatabaseMissing('users', ['id' => $guest->id, 'deleted_at' => null]);
});

it('can register as user', function () {
    $guest = User::factory()
        ->guest()
        ->createOne([
            'password' => ($password = '12312313'),
        ]);

    Mail::fake();

    Mail::assertNothingOutgoing();

    $guest = asTestGuest($guest);

    postJson(route('api.auth.register'), [
        'first_name' => $guest->first_name,
        'last_name' => $guest->last_name,
        'email' => $guest->email,
        'phone' => $guest->phone,
        'password' => $password,
        'passwordConfirmation' => $password,
    ])->assertOk();

    assertDatabaseHas('users', ['id' => $guest->id, 'deleted_at' => null]);

    Mail::assertSent(UserRegisteredMail::class);
});
