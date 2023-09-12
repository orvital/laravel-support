<?php

namespace Orvital\Support\Structure;

class Registry
{
    public function __construct(
        protected array $items = [],
    ) {
    }

    public function all(): array
    {
        return $this->items;
    }

    public function get(string $key): ?string
    {
        return $this->has($key) ? $this->items[$key] : null;
    }

    public function set(string $key, string $value): void
    {
        $this->items[$key] = $value;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->items);
    }
}
