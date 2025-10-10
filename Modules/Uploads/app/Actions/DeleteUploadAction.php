<?php

namespace Modules\Uploads\Actions;

use Illuminate\Support\Facades\Storage;
use Modules\Uploads\Models\Upload;

class DeleteUploadAction
{
    public function handle(Upload $upload): ?bool
    {
        Storage::disk('public')->delete($upload->path);

        return $upload->delete();
    }
}
