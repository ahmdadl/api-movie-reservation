<?php

declare(strict_types=1);

namespace Modules\Core\Mixins;

use Closure;
use Illuminate\Support\Facades\Route;
use LaravelLocalization;

final class RouteMixins
{
    /**
 * add web routes
 * these routes will be used with for website with localization
 *
 * @return Closure
 */
    // public function web()
    // {
    //     return fn() => Route::prefix(LaravelLocalization::setLocale())
    //         ->middleware([
    //             "web",
    //             "localeSessionRedirect",
    //             "localizationRedirect",
    //         ])
    //         ->group(fn() => $this);
    // }
}
