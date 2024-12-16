<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleManufacturer extends Model
{

    protected $table = 'vehicle_manufacturers';

    protected $fillable = ['name'];
    public $timestamps = true;


    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'manufacturer_id');
    }
}