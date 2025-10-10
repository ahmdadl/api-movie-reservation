<?php

namespace Modules\Uploads\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class UploadsPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Uploads';
    }

    public function getId(): string
    {
        return 'uploads';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
