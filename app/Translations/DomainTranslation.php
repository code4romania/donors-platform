<?php

declare(strict_types=1);

namespace App\Translations;

use App\Models\Domain;

class DomainTranslation extends Translation
{
    protected $baseModel = Domain::class;
}
