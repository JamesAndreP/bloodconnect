<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationRequestSchedule extends Model
{
    use HasFactory;

    protected $table = 'donation_request_schedules';

    protected $fillable = [
        'donation_request_id',
        'date',
        'notes',
        'status',
    ];

    // timestamps are enabled by default, no need to set $timestamps = false

    /**
     * Relationship: belongs to DonationRequest
     */
    public function donationRequest()
    {
        return $this->belongsTo(DonationRequest::class, 'donation_request_id');
    }
}
