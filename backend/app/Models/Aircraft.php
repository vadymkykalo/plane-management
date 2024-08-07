<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    use HasFactory;

    protected $hidden = ['is_deleted', 'updated_at'];

    protected $fillable = [
        'model',
        'serial_number',
        'registration',
        'maintenance_history',
        'maintenance_company_id',
        'is_deleted'
    ];

    public function maintenanceCompany()
    {
        return $this->belongsTo(MaintenanceCompany::class);
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }
}
