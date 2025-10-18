<?php

namespace Modules\Cinemas\ValueObjects;
use Illuminate\Contracts\Support\Jsonable;

final class CinemaAddress implements Jsonable
{
    public function __construct(
        public string $g_map_url,
        public string $line1,
        public ?string $line2 = null,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'g_map_url' => $this->g_map_url,
            'line1' => $this->line1,
            'line2' => $this->line2,
        ];
    }

    /**
     * Create a CinemaAddress object from an array
     */
    public static function fromArray(array $data): self
    {
        return new self($data['g_map_url'], $data['line1'], $data['line2']);
    }

    public static function defaults(): array
    {
        return [
            'g_map_url' => '',
            'line1' => '',
            'line2' => null,
        ];
    }

    /**
     * turn object to json string
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) json_encode($this->toArray());
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
