<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $hidden = ['is_deleted', 'updated_at'];

    protected $fillable = [
        'aircraft_id',
        'issue_description',
        'priority',
        'due_date',
        'status',
        'is_deleted'
    ];

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class);
    }
}
