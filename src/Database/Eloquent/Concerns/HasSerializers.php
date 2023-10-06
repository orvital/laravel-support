<?php

namespace Orvital\Support\Database\Eloquent\Concerns;

use DateTimeInterface;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasSerializers
{
    /**
     * toIso8601ZuluString()        2019-02-01T03:45:27Z
     * toDateTimeLocalString()      2019-02-01T03:45:27
     * toRfc822String()             Fri, 01 Feb 19 03:45:27 +0000
     * toRfc850String()             Friday, 01-Feb-19 03:45:27 UTC
     * toRfc1036String()            Fri, 01 Feb 19 03:45:27 +0000
     * toRfc1123String()            Fri, 01 Feb 2019 03:45:27 +0000
     * toRfc2822String()            Fri, 01 Feb 2019 03:45:27 +0000
     * toRfc3339String()            2019-02-01T03:45:27+00:00
     * toRfc7231String()            Fri, 01 Feb 2019 03:45:27 GMT
     * toRssString()                Fri, 01 Feb 2019 03:45:27 +0000
     * toW3cString()                2019-02-01T03:45:27+00:00
     *
     * @param  \Carbon\CarbonImmutable  $date
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->toIso8601ZuluString();
    }
}
