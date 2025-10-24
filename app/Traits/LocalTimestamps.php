<?php

namespace App\Traits;

use DateTimeInterface;

trait LocalTimestamps
{
    /** @param \Illuminate\Support\Carbon $date */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Africa/Cairo')->format('Y-m-d H:i:s');
    }
}
