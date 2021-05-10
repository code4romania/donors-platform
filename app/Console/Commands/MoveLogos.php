<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Donor;
use App\Models\GrantManager;
use App\Models\Model;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class MoveLogos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:logos';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $prefix = Storage::disk('public')->getAdapter()->getPathPrefix();

        collect()
            ->merge(Donor::all('id'))
            ->merge(GrantManager::all('id'))
            ->filter(fn (Model $model) => $model->getFirstMedia('logo'))
            ->each(function (Model $model) use ($prefix) {
                $media = $model->getFirstMedia('logo');

                $old = Str::after($media->getPath(), $prefix);
                $new = sprintf('logos/%s-%d.png', $model->getMorphClass(), $model->id);

                $image = Image::make($media->getPath())
                    ->resize(null, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->interlace()
                    ->encode('png');

                Storage::disk('public')->put($model->logoPath(), (string) $image);

                $media->delete();

                $this->info("{$old} => {$model->logoPath()}");
            });

        return 0;
    }
}
