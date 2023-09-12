<?php

namespace Orvital\Support\Database\Eloquent\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait Sluggable
{
    /**
     * Boot the trait for the model class.
     */
    public static function bootSluggable(): void
    {
        // The saving event is dispatched before creating or updating the model, even if the attributes have not changed.
        static::saving(function (Model $model) {
            $model->setSluggables();
        });
    }

    /**
     * Initialize the trait for the model instance.
     */
    public function initializeSluggable(): void
    {
        $this->mergeFillable(array_values($this->getSluggables()));
    }

    /**
     * Get the sluggable attributes map for the model.
     */
    public function getSluggables(): array
    {
        return ['slug' => 'name'];
    }

    /**
     * Set the sluggable attributes for the model.
     */
    public function setSluggables(): self
    {
        foreach ($this->getSluggables() as $target => $source) {
            $this->{$target} = $this->slugify($this->{$source});
        }

        return $this;
    }

    /**
     * Generate a URL friendly slug from a given string.
     */
    public static function slugify(string $value): string
    {
        return Str::slug($value);
    }
}
