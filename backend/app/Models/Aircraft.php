<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    use HasFactory;

    protected $table = 'aircrafts';

    protected $hidden = [
        'is_deleted', 'created_at', 'updated_at'
    ];

    protected $fillable = ['model', 'serial_number', 'registration'];

    protected $casts = [
        'is_deleted' => 'boolean',
    ];

    public function maintenanceCompanies()
    {
        return $this->belongsToMany(MaintenanceCompany::class, 'aircraft_maintenance_company');
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('is_deleted', false);
    }
}
