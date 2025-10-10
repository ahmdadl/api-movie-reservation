<?php

declare(strict_types=1);

namespace Modules\Uploads\Actions;

use Illuminate\Support\Facades\Storage;
use Modules\Uploads\Models\Upload;

final class DeleteUploadAction
{
    public function handle(Upload $upload): ?bool
    {
        Storage::disk('public')->delete($upload->path);

        return $upload->delete();
    }
}
