<?php

namespace App\Traits;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait LocalTimestamps
{
    /** @param \Illuminate\Support\Carbon $date */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Africa/Cairo')->format('Y-m-d H:i:s');
    }
}
