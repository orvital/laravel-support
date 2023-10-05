<?php

namespace Orvital\Support\Extensions\Session;

use Illuminate\Session\Store as BaseStore;
use Illuminate\Support\Str;

class Store extends BaseStore
{
    /**
     * Determine if this is a valid session ID.
     *
     * @param  string  $id
     * @return bool
     */
    public function isValidId($id)
    {
        return Str::isUlid($id);
    }

    /**
     * Get a new, random session ID.
     *
     * @return string
     */
    protected function generateSessionId()
    {
        return (string) Str::ulid();
    }
}
