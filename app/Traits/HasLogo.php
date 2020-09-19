<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasLogo
{
    use InteractsWithMedia;

    public function getLogoAttribute(): string
    {
        return $this->getFirstMediaUrl(
            'logo',
            '300x300'
        );
    }

    public function setLogoAttribute(?UploadedFile $file = null): void
    {
        if (! $file) {
            return;
        }

        $this->addMedia($file)
            ->toMediaCollection('logo');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('300x300')
            ->performOnCollections('logo')
            ->width(300)
            ->height(300);
    }
}
