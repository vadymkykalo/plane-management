<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AircraftMaintenanceCompany extends Model
{
    use HasFactory;

    protected $table = 'aircraft_maintenance_company';

    protected $hidden = [
        'is_deleted', 'created_at', 'updated_at'
    ];

    protected $fillable = [
        'service_requests_id', 'aircraft_id', 'maintenance_company_id', 'created_at', 'updated_at'
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_requests_id', 'id');
    }

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class);
    }

    public function maintenanceCompany()
    {
        return $this->belongsTo(MaintenanceCompany::class);
    }
}

