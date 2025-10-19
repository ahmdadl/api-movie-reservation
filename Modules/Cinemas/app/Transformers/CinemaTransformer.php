<?php

namespace Modules\Cinemas\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Cinemas\Models\Cinema;
use Modules\Cities\Transformers\CityTransformer;

class CinemaTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        /** @var Cinema $this */

        return [
            'id' => $this->id,
            'cityId' => $this->city_id,
            'parentCinemaId' => $this->parent_cinema_id,
            'title' => $this->title,
            'address' => $this->address,
            'phone' => [
                'country' => $this->phone->getCountry(),
                'national' => $this->phone->formatNational(),
                'e164' => $this->phone->formatE164(),
            ],
            'email' => $this->email,
            // 'isActive' => $this->is_active,
            'createdAt' => $this->created_at,

            'city' => new CityTransformer($this->whenLoaded('city')),
            'parentCinema' => new self($this->whenLoaded('parentCinema')),
            'cinemas' => self::collection($this->whenLoaded('cinemas')),
        ];
    }
}
