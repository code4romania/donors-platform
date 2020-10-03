<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * @method static self foundation()
 * @method static self federation()
 * @method static self company()
 */
final class OrganizationType extends Enum
{
    protected static function labels(): array
    {
        return [
            'foundation' => __('dashboard.org_type.foundation'),
            'federation' => __('dashboard.org_type.federation'),
            'company'    => __('dashboard.org_type.company'),
        ];
    }
}
