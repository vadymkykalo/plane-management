<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceCompany extends Model
{
    use HasFactory;

    protected $hidden = ['is_deleted', 'updated_at'];

    protected $fillable = [
        'name',
        'contact',
        'specialization',
        'is_deleted'
    ];

    public function aircrafts()
    {
        return $this->hasMany(Aircraft::class);
    }
}
