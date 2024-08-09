<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';

    protected $table = 'service_requests';

    protected $hidden = [
        'is_deleted', 'created_at', 'updated_at'
    ];

    protected $fillable = [
        'aircraft_id', 'maintenance_company_id', 'issue_description', 'priority', 'due_date', 'status'
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
    ];

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class);
    }

    public function maintenanceCompany()
    {
        return $this->belongsTo(MaintenanceCompany::class);
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('is_deleted', false);
    }
}
