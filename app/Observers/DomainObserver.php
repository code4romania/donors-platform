<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Domain;
use Illuminate\Support\Facades\Cache;

class DomainObserver
{
    private function clearCache()
    {
        Cache::tags('domains')->flush();
    }

    public function created(Domain $domain): void
    {
        $this->clearCache();
    }

    public function updated(Domain $domain): void
    {
        $this->clearCache();
    }

    public function deleted(Domain $domain): void
    {
        $this->clearCache();
    }

    public function restored(Domain $domain): void
    {
        $this->clearCache();
    }

    public function forceDeleted(Domain $domain): void
    {
        $this->clearCache();
    }
}
