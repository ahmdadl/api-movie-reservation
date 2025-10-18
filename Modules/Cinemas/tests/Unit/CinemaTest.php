<?php

use Modules\Cinemas\Models\Cinema;
use Modules\Cinemas\ValueObjects\CinemaAddress;

it('has cast as cinema address', function () {
    $cinema = Cinema::factory()->create();

    expect($cinema->address)->toBeInstanceOf(CinemaAddress::class);
});
