<?php

use Modules\Genres\Models\Genre;

it('have a slug', function () {
    $genre = Genre::factory()->create();
    expect($genre->slug)->not()->toBeNull();
});
