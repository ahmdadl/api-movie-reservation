<?php

use Modules\Cinemas\Models\Cinema;
use Modules\Cinemas\ValueObjects\CinemaAddress;
use Propaganistas\LaravelPhone\PhoneNumber;

it('has cast as cinema address', function () {
    $cinema = Cinema::factory()->create();

    expect($cinema->address)->toBeInstanceOf(CinemaAddress::class);
});

it('has phone cast', function () {
    $cinema = Cinema::factory()->create();

    expect($cinema->phone)->toBeInstanceOf(PhoneNumber::class);
});
