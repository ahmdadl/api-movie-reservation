<?php

namespace Modules\Cities\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class CitiesPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Cities';
    }

    public function getId(): string
    {
        return 'cities';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
