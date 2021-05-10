<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait HasLogo
{
    public function getLogoAttribute(): ?string
    {
        return Storage::disk('public')->exists($this->logoPath())
            ? Storage::disk('public')->url($this->logoPath())
            : null;
    }

    public function setLogoAttribute(?UploadedFile $file = null): void
    {
        if (! $file) {
            return;
        }

        Storage::disk('public')->put(
            $this->logoPath(),
            Image::make($file->path())
                ->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->interlace()
                ->encode('png')
        );
    }

    public function logoPath(): string
    {
        return sprintf('logos/%s-%d.png', $this->getMorphClass(), $this->id);
    }
}
