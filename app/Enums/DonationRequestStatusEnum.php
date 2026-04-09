<?php

namespace App\Enums;

enum DonationRequestStatusEnum: string
{
    case Pending = 'Pending';
    case RescheduleRequest = 'RescheduleRequest';
    case Approved = 'Approved';
    case Cancelled = 'Cancelled';
}
