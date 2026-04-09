<?php

namespace App\Enums;

enum BloodRequestStatusEnum: string
{
    case Pending = 'Pending';
    case Fulfilled = 'Fulfilled';
}
