<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleSpeedGovernorCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'certificate_no',
        'class_no',
        'type_of_governor',
        'date_of_installation',
        'expiry_date',
        'certificate_copy',
        'chasis_no',
        'status',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}