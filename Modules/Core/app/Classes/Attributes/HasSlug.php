<?php

namespace Modules\Core\Classes\Attributes;

use Attribute;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use ReflectionClass;

/**
 * PHP 8+ Attribute-based slug configuration for Eloquent models.
 *
 * Example:
 * #[HasSlug(source: 'title')]
 * #[HasSlug(source: ['title', 'subtitle'], slugField: 'permalink', onUpdate: true)]
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class HasSlug
{
    protected static array $configCache = [];
    protected static array $bootCache = [];

    public function __construct(
        public string|array $source = 'title',
        public string $slugField = 'slug',
        public bool $onUpdate = false,
        public ?string $method = null,
        public ?string $separator = null,
        public ?bool $unique = null,
        public ?bool $includeTrashed = null,
        public ?int $maxLength = null,
        public ?int $maxLengthKeepWords = null,
        public ?bool $reserved = null,
        public ?bool $uniqueSuffix = null,
    ) {}

    /**
     * Apply configuration to a model instance.
     */
    public function apply(Model $model): void
    {
        // Define sluggable() macro once
        if (!$model::hasMacro('sluggable')) {
            $model::macro('sluggable', function () {
                return HasSlug::collectFor($this);
            });
        }

        // Add Sluggable trait dynamically if not already present
        if (!in_array(Sluggable::class, class_uses_recursive($model))) {
            $model->addTrait(Sluggable::class);
        }
    }

    /**
     * Gather all HasSlug attributes for a model.
     */
    public static function collectFor(Model $model): array
    {
        $class = get_class($model);

        if (isset(self::$configCache[$class])) {
            return self::$configCache[$class];
        }

        $ref = new ReflectionClass($class);
        $attrs = $ref->getAttributes(self::class);

        $config = [];
        foreach ($attrs as $attr) {
            /** @var self $instance */
            $instance = $attr->newInstance();

            $config[$instance->slugField] = array_filter([
                'source' => $instance->source,
                'onUpdate' => $instance->onUpdate,
                'method' => $instance->method,
                'separator' => $instance->separator,
                'unique' => $instance->unique,
                'includeTrashed' => $instance->includeTrashed,
                'maxLength' => $instance->maxLength,
                'maxLengthKeepWords' => $instance->maxLengthKeepWords,
                'reserved' => $instance->reserved,
                'uniqueSuffix' => $instance->uniqueSuffix,
            ]);
        }

        return self::$configCache[$class] = $config;
    }

    /**
     * Register global boot listener.
     */
    public static function register(): void
    {
        static $registered = false;
        if ($registered) {
            return;
        }
        $registered = true;

        Event::listen('eloquent.booting: *', function (
            string $event,
            array $payload,
        ) {
            $model = $payload[0];
            $class = get_class($model);

            // If already processed, skip
            if (isset(self::$bootCache[$class])) {
                return;
            }

            $ref = new ReflectionClass($model);
            $attrs = $ref->getAttributes(self::class);

            if (!empty($attrs)) {
                foreach ($attrs as $attr) {
                    $instance = $attr->newInstance();
                    $instance->apply($model);
                }
                self::$bootCache[$class] = true;
            } else {
                self::$bootCache[$class] = false;
            }
        });
    }
}
