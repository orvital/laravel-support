<?php

namespace Orvital\Support\Cache;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Str;

class Throttler
{
    public function __construct(
        protected RateLimiter $limiter,
        protected string $key = '',
        protected int $retries = 5, // maximum number of allowed attempts per minute
        protected int $timeout = 60, // number of seconds until the available attempts are reset
    ) {
        $this->key($key);
    }

    /**
     * Set or get key.
     */
    public function key(string $key = null): string
    {
        if ($key) {
            $this->key = Str::slug($key);
        }

        return $this->key;
    }

    /**
     * Set limiter configuration.
     */
    public function for(string $key, int $retries = 5, int $timeout = 60): self
    {
        $this->key($key);
        $this->retries = $retries;
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Attempts to execute a callback if it's not limited.
     */
    public function attempt(Closure $callback): mixed
    {
        return $this->limiter->attempt($this->key, $this->retries, $callback, $this->timeout);
    }

    /**
     * Determine number of attempts for the given key above the limit.
     */
    public function tooManyAttempts(): bool
    {
        return $this->limiter->tooManyAttempts($this->key, $this->retries);
    }

    /**
     * Determine number of attempts for the given key below the limit.
     */
    public function check(): bool
    {
        return ! $this->tooManyAttempts();
    }

    /**
     * Increment the counter for a given key for a given decay time.
     */
    public function hit(): int
    {
        return $this->limiter->hit($this->key, $this->timeout);
    }

    /**
     * Get the number of attempts for the given key.
     */
    public function attempts(): mixed
    {
        return $this->limiter->attempts($this->key);
    }

    /**
     * Reset the number of attempts for the given key.
     */
    public function resetAttempts(): mixed
    {
        return $this->limiter->resetAttempts($this->key);
    }

    /**
     * Get the number of retries left for the given key.
     */
    public function remaining(): int
    {
        return $this->limiter->remaining($this->key, $this->retries);
    }

    /**
     * Get the number of retries left for the given key.
     */
    public function retriesLeft(): int
    {
        return $this->limiter->retriesLeft($this->key, $this->retries);
    }

    /**
     * Clear the hits and lockout timer for the given key.
     */
    public function clear(): void
    {
        $this->limiter->clear($this->key);
    }

    /**
     * Get the number of seconds until the "key" is accessible again.
     */
    public function availableIn(): int
    {
        return $this->limiter->availableIn($this->key);
    }

    /**
     * Clean the rate limiter key from unicode characters.
     */
    public function cleanRateLimiterKey(): string
    {
        return $this->limiter->cleanRateLimiterKey($this->key);
    }
}
