<?php

namespace Orvital\Support\Database\Eloquent\Concerns;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasUlid
{
    use HasUlids;

    public function initializeHasUlids()
    {
        $this->keyType = 'string';
        $this->incrementing = false;
        $this->usesUniqueIds = true;
    }

    public function newUniqueId()
    {
        return (string) Str::ulid();
    }
}
