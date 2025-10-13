<?php

namespace Modules\Cities\Filament\Resources\Cities\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Cities\Filament\Resources\Cities\CityResource;

class CreateCity extends CreateRecord
{
    protected static string $resource = CityResource::class;
}
