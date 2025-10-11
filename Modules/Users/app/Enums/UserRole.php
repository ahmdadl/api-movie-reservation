<?php

declare(strict_types=1);

namespace Modules\Users\Enums;

use Modules\Core\Traits\HasActionHelpers;

enum UserRole: string
{
    use HasActionHelpers;

    case ADMIN = 'admin';
    case USER = 'user';

    case GUEST = 'guest';
}
