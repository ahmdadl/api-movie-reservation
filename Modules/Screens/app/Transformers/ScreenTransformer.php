<?php

namespace Modules\Screens\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScreenTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cinemaId' => $this->cinema_id,
            'title' => $this->title,
            'totalSeats' => $this->total_seats,
            'createdAt' => $this->created_at,

            // 'cinema' => new CinemaTransformer($this->whenLoaded('cinema')),
        ];
    }
}
