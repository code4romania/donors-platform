<?php

declare(strict_types=1);

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class ActivityObserver
{
    public function created(Model $model): void
    {
        activity()->performedOn($model)->log('created');
    }

    public function updated(Model $model): void
    {
        activity()->performedOn($model)->log('updated');
    }

    public function deleted(Model $model): void
    {
        activity()->performedOn($model)->log('deleted');
    }

    public function restored(Model $model): void
    {
        activity()->performedOn($model)->log('restored');
    }

    public function forceDeleted(Model $model): void
    {
        activity()->performedOn($model)->log('forceDeleted');
    }
}
