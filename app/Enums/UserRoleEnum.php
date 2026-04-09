<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case Admin = 'admin';
    case Donor = 'donor';
    case HospitalAdmin = 'hospital';
}
