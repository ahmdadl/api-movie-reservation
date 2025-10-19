<?php

namespace Modules\Seats\Enums;

enum SeatType: string
{
    use \Modules\Core\Traits\HasEnumHelpers;

    case VIP = 'vip';
    case NORMAL = 'normal';
}
