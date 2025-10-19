<?php

namespace Modules\Genres\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Genres\Models\Genre;

class GenreTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        /** @var Genre&JsonResource $this */

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'createdAt' => $this->created_at,
        ];
    }
}
