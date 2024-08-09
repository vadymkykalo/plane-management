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
        'created_at', 'updated_at'
    ];

    protected $fillable = [
        'aircraft_id', 'maintenance_company_id', 'issue_description', 'priority', 'due_date', 'status'
    ];

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class);
    }

    public function maintenanceCompany()
    {
        return $this->belongsTo(MaintenanceCompany::class);
    }
}
