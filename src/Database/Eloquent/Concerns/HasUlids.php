<?php

namespace Orvital\Support\Database\Eloquent\Concerns;

use Illuminate\Database\Eloquent\Concerns\HasUlids as BaseHasUlids;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasUlids
{
    use BaseHasUlids;

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
