<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * @method static self admin()
 * @method static self donor()
 * @method static self manager()
 * @method static self analyst()
 */
final class UserRole extends Enum
{
    protected static function labels(): array
    {
        return [
            'admin'   => __('dashboard.role.admin'),
            'donor'   => __('dashboard.role.donor'),
            'manager' => __('dashboard.role.manager'),
            'analyst' => __('dashboard.role.analyst'),
        ];
    }
}
