<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quantity extends Model
{
    protected $table = 'quantities';

    protected $fillable = [
        'hospital_id',
        'donation_request_id',
        'blood_request_id',
        'quantity',
        'previous_quantity',
        'current_quantity',
        'type',
        'blood_type',
        'status',
    ];

    /**
     * Relationships
     */

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function donationRequest()
    {
        return $this->belongsTo(DonationRequest::class);
    }

    public function bloodRequest()
    {
        return $this->belongsTo(BloodRequest::class);
    }
}
