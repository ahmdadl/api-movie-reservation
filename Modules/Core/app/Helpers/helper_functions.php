<?php

declare(strict_types=1);

if (! function_exists('api')) {
    /**
     * api response
     *
     * @return Modules\Core\Utils\ApiResponse
     */
    function api()
    {
        return app(Modules\Core\Utils\ApiResponse::class);
    }
}

// if (! function_exists('user')) {
//     /**
//      * get current user
//      */
//     function user(?string $guard = null): ?User
//     {
//         return auth()->guard($guard)->user();
//     }
// }

// if (! function_exists('settings')) {
//     function settings(?string $group = null): mixed
//     {
//         $settings = Modules\Settings\Utils\SettingUtils::getCachedSettings();

//         if ($group === null) {
//             return $settings;
//         }

//         return $settings[$group] ?? null;
//     }
// }

// if (! function_exists('multiLangInput')) {
//     function multiLangInput(
//         Filament\Forms\Components\TextInput|Filament\Forms\Components\Textarea|Filament\Forms\Components\RichEditor $input
//     ): array {
//         $clone = clone $input;
//         $name = $input->getName();
//         $label = $input->getLabel();

//         // @phpstan-ignore-next-line
//         $enLabel = __('english_label', compact('label'));
//         // @phpstan-ignore-next-line
//         $arLabel = __('arabic_label', compact('label'));

//         return [
//             $input
//                 ->make($name.'.en')
//                 ->label($enLabel)
//                 ->required($input->isRequired()),
//             $clone
//                 ->make($name.'.ar')
//                 ->label($arLabel)
//                 ->required($input->isRequired()),
//         ];
//     }
// }

// if (! function_exists('metaTabInputs')) {
//     function metaTabInputs(): Filament\Forms\Components\Tabs\Tab
//     {
//         return Filament\Forms\Components\Tabs\Tab::make('meta')
//             ->label('meta')
//             ->translateLabel()
//             ->icon('heroicon-m-queue-list')
//             ->schema([
//                 ...multiLangInput(
//                     Filament\Forms\Components\TextInput::make(
//                         'meta_title'
//                     )->translateLabel()
//                 ),
//                 ...multiLangInput(
//                     Filament\Forms\Components\Textarea::make(
//                         'meta_description'
//                     )->translateLabel()
//                 ),
//                 Filament\Forms\Components\TagsInput::make('meta_keywords')
//                     ->columnSpanFull()
//                     ->translateLabel()
//                     ->placeholder(__('meta_keywords')),
//             ])
//             ->columns(2);
//     }
// }

// if (! function_exists('activeToggler')) {
//     function activeToggler(): mixed
//     {
//         return Filament\Tables\Filters\Filter::make('is_active')
//             ->form([
//                 Filament\Forms\Components\ToggleButtons::make('is_active')
//                     ->translateLabel()
//                     ->grouped()
//                     ->options([
//                         'active' => __('Active'),
//                         'inactive' => __('Inactive'),
//                         'all' => __('All'),
//                     ])
//                     ->icons([
//                         'active' => 'heroicon-o-shield-check',
//                         'inactive' => 'heroicon-o-shield-exclamation',
//                         'all' => 'heroicon-o-no-symbol',
//                     ])
//                     ->default('all'),
//             ])
//             ->query(function (
//                 Illuminate\Database\Eloquent\Builder $query,
//                 array $data
//             ): Illuminate\Database\Eloquent\Builder {
//                 return $query->when(
//                     $activeState = $data['is_active'],
//                     fn ($q) => $q
//                         ->when(
//                             $activeState === 'active',
//                             fn ($q) => $q->where('is_active', true)
//                         )
//                         ->when(
//                             $activeState === 'inactive',
//                             fn ($q) => $q->where('is_active', false)
//                         )
//                 );
//             });
//     }
// }

// // if (!function_exists("uploads_path")) {
// //     function uploads_path(?string $path = null): string
// //     {
// //         $path = $path
// //             ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR)
// //             : "";

// //         return storage_path(
// //             "app" .
// //                 DIRECTORY_SEPARATOR .
// //                 "public" .
// //                 DIRECTORY_SEPARATOR .
// //                 Modules\Uploads\Models\Upload::UPLOAD_DIR .
// //                 $path
// //         );
// //     }
// // }

// if (! function_exists('uploads_url')) {
//     function uploads_url(?string $path = null): string
//     {
//         /** @var string $uploadsUrl */
//         $uploadsUrl = config('app.uploads_url', '');

//         if (! $path) {
//             return $uploadsUrl;
//         }

//         return $uploadsUrl.'/'.$path;
//     }
// }

// if (! function_exists('sendMail')) {
//     function sendMail(string $to, Illuminate\Mail\Mailable $mail): void
//     {
//         try {
//             Illuminate\Support\Facades\Mail::to($to)->send($mail);
//         } catch (Throwable $th) {
//             logger()->error($th->getMessage());
//             throw $th;
//         }
//     }
// }

// if (! function_exists('enumOptions')) {
//     /**
//      * get localized enum options
//      *
//      * @param  BackedEnum  $enum
//      * @return array<array|string|null>
//      */
//     function enumOptions(mixed $enum): array
//     {
//         $options = [];
//         foreach ($enum::cases() as $case) {
//             // @phpstan-ignore-next-line
//             $options[$case->value] = __($case->value);
//         }

//         return $options;
//     }
// }

// if (! function_exists('testMail')) {
//     function testMail(Illuminate\Mail\Mailable $mailable): mixed
//     {
//         // @phpstan-ignore-next-line
//         return $mailable->toMail((object) [])->render();
//     }
// }

// if (! function_exists('sortOrderInput')) {
//     function sortOrderInput(string $model): Filament\Forms\Components\TextInput
//     {
//         return Filament\Forms\Components\TextInput::make('sort_order')
//             ->translateLabel()
//             ->numeric()
//             ->default(fn () => $model::max('sort_order') + 1)
//             ->suffixAction(
//                 Filament\Forms\Components\Actions\Action::make(
//                     'latestSortOrder'
//                 )
//                     ->icon('heroicon-m-wrench-screwdriver')
//                     ->label(__('SetToLatest'))
//                     ->action(function (Filament\Forms\Set $set, $state) use (
//                         $model
//                     ) {
//                         $set('sort_order', $model::max('sort_order') + 1);
//                     })
//             );
//     }
// }

// if (! function_exists('parsePhone')) {
//     function parsePhone(
//         string $phoneNumber,
//         string $countryCode = 'EG'
//     ): object|false {
//         $phoneUtil = libphonenumber\PhoneNumberUtil::getInstance();
//         try {
//             $phoneProto = $phoneUtil->parse($phoneNumber, $countryCode);
//             if (! $phoneUtil->isValidNumber($phoneProto)) {
//                 return false;
//             }

//             return (object) [
//                 'full' => $phoneProto->getCountryCode().
//                     $phoneProto->getNationalNumber(),
//                 'national' => $phoneProto->getNationalNumber(),
//                 'country' => $phoneProto->getCountryCode(),
//             ];
//         } catch (Exception $e) {
//             return false;
//         }
//     }
// }

// if (! function_exists('asUser')) {
//     function asUser(User $user, callable $callback, ?string $guard = null): void
//     {
//         $currentUser = auth($guard)->user();

//         auth($guard)->setUser($user);

//         $callback();

//         auth($guard)->setUser($currentUser);
//     }
// }

// if (! function_exists('frontUrl')) {
//     function frontUrl(string $path = ''): string
//     {
//         return config('app.front_url', '').'/'.mb_ltrim($path, '/');
//     }
// }

// if (! function_exists('forgetLocalizedCache')) {
//     function forgetLocalizedCache(string $key): void
//     {
//         foreach (config('app.supported_locales') as $locale) {
//             cache()->forget($key.'_'.$locale);
//         }
//     }
// }

// if (! function_exists('nationalPhone')) {
//     function nationalPhone(string $fullPhone): string
//     {
//         return preg_replace(
//             '/[^0-9]/',
//             '',
//             phone($fullPhone)->formatNational()
//         );
//     }
// }

// if (! function_exists('fakeLbPhone')) {
//     /**
//      * generate fake lebanese phone
//      */
//     function fakeLbPhone(): string
//     {
//         $nums = [
//             '81611638',
//             '71421390',
//             '71367925',
//             '76003563',
//             '71222676',
//             '70394313',
//             '70295620',
//             '76951539',
//             '71015476',
//             '71175731',
//             '70651500',
//             '70534015',
//             '71015567',
//             '76088901',
//             '70622063',
//             '70223808',
//             '81229607',
//             '70858157',
//             '71654194',
//             '70067374',
//             '81802691',
//             '71748324',
//             '70502311',
//             '81663633',
//         ];

//         $num = $nums[array_rand($nums)];

//         return str($num)
//             ->substr(0, 4)
//             ->append((string) random_int(1000, 9999))
//             ->toString();
//     }
// }

// if (! function_exists('wishlistService')) {
//     function wishlistService(): ?Modules\Wishlists\Services\WishlistService
//     {
//         return app(Modules\Wishlists\Services\WishlistService::class);
//     }
// }

// if (! function_exists('systemUser')) {
//     function systemUser(): User
//     {
//         return User::admin()->firstOrCreate(
//             [
//                 'email' => 'system_admin@site.com',
//             ],
//             [
//                 'name' => 'System Admin',
//                 'phone' => fakeLbPhone(),
//                 'password' => str()->random(12),
//             ]
//         );
//     }
// }
