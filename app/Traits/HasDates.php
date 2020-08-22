<?php

declare(strict_types=1);

namespace App\Traits;

trait HasDates
{
    public function getFormattedStartDateAttribute(): ?string
    {
        if (! $this->start_date) {
            return null;
        }

        return $this->start_date->format('Y-m-d');
    }

    public function getFormattedEndDateAttribute(): ?string
    {
        if (! $this->end_date) {
            return null;
        }

        return $this->end_date->format('Y-m-d');
    }
}
