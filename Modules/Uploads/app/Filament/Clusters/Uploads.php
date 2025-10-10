<?php

declare(strict_types=1);

namespace Modules\Uploads\Filament\Clusters;

use Filament\Clusters\Cluster;
use Nwidart\Modules\Facades\Module;

final class Uploads extends Cluster
{
    public static function getModuleName(): string
    {
        return 'Uploads';
    }

    public static function getModule(): \Nwidart\Modules\Module
    {
        return Module::findOrFail(self::getModuleName());
    }

    public static function getNavigationLabel(): string
    {
        return __('Uploads');
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-squares-2x2';
    }
}
