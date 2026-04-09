<?php

namespace App\Enums;

enum DonationRequestScheduleStatusEnum: string
{
    case Pending = 'Pending';
    case Active = 'Active';
    case Inactive = 'Inactive';
    case Declined = 'Declined';
}
