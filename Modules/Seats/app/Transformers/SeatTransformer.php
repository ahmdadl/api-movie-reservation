<?php

namespace Modules\Seats\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Screens\Transformers\ScreenTransformer;
use Modules\Seats\Models\Seat;

class SeatTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        /** @var Seat&JsonResource $this */

        return [
            'id' => $this->id,
            'screenId' => $this->screen_id,
            'type' => $this->type,
            'row' => $this->row,
            'column' => $this->column,
            'sortOrder' => $this->sort_order,
            'createdAt' => $this->created_at,

            'screen' => new ScreenTransformer($this->whenLoaded('screen')),
        ];
    }
}
