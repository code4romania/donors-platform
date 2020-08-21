<?php

declare(strict_types=1);

namespace App\Traits;

trait HasDates
{
    public function getFormattedStartDateAttribute(): string
    {
        return $this->start_date->format('Y-m-d');
    }

    public function getFormattedEndDateAttribute(): string
    {
        return $this->end_date->format('Y-m-d');
    }
}
