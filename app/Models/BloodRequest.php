<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    use HasFactory;

    protected $table = 'blood_requests';

    protected $fillable = [
        'hospital_id',
        'blood_type',
        'quantity',
        'urgency_lvl',
        'request_date',
        'confirmed_by',
        'status',
    ];

    protected $casts = [
        'request_date' => 'datetime',
    ];

    /**
     * Relationship: BloodRequest belongs to a Hospital
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Relationship: BloodRequest may be confirmed by a Hospital
     */
    public function confirmedBy()
    {
        return $this->belongsTo(Hospital::class, 'confirmed_by');
    }
}
