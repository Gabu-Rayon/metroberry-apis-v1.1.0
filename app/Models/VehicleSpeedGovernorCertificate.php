<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleSpeedGovernorCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_no',
        'vehicle_id',
        'class_no',
        'type_of_governor',
        'date_of_installation',
        'expiry_date',
        'certificate_copy',
    ];

    // Define relationship with Vehicle model
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}