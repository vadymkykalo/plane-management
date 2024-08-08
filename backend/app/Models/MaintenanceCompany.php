<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceCompany extends Model
{
    use HasFactory;

    protected $table = 'maintenance_companies';

    protected $hidden = [
        'is_deleted', 'created_at', 'updated_at'
    ];

    protected $fillable = ['name', 'contact', 'specialization'];

    protected $casts = [
        'is_deleted' => 'boolean',
    ];

    public function aircrafts()
    {
        return $this->belongsToMany(Aircraft::class, 'aircraft_maintenance_company');
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
