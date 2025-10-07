<?php

declare(strict_types=1);

namespace Modules\Core\Utils;

use Illuminate\Http\UploadedFile;

// use Modules\Uploads\Actions\StoreUploadAction;
// use Modules\Uploads\Models\Upload;

final class FilamentUtils
{
    // public static function storeSingleFile(mixed $state): ?string
    // {
    //     if (! is_array($state)) {
    //         return null;
    //     }
    //     $key = array_key_first($state);
    //     if (empty($key)) {
    //         return null;
    //     }
    //     /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|string $file */
    //     $file = $state[$key];
    //     if (is_string($file)) {
    //         // @phpstan-ignore-next-line
    //         return Upload::firstWhere('path', $file)?->id;
    //     }
    //     return self::storeTempFile($file);
    // }
    // /**
    //  * store multiple file
    //  */
    // public static function storeMultipleFile(mixed $state): ?array
    // {
    //     if (! is_array($state)) {
    //         return null;
    //     }
    //     /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile[] $files */
    //     $files = $state;
    //     return array_map(function ($file) {
    //         return static::storeTempFile($file);
    //     }, $files);
    // }
    // /**
    //  * store temp file
    //  */
    // public static function storeTempFile(
    //     \Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file
    // ): string {
    //     $action = new StoreUploadAction;
    //     $fileRecord = $action->handle(
    //         new UploadedFile(
    //             $file->path(),
    //             $file->getClientOriginalName(),
    //             $file->getMimeType()
    //         )
    //     );
    //     // delete temp file
    //     $file->delete();
    //     // @phpstan-ignore-next-line
    //     return $fileRecord->id;
    // }
}
