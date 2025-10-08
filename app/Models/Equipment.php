<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'equipment_number',
        'description',
        'manufacturer',
        'model',
        'serial_number',
        'purchase_date',
        'purchase_price',
        'status',
        'location',
        'assigned_to',
        'next_maintenance_date',
        'maintenance_interval_days',
        'notes',
        'specifications',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'next_maintenance_date' => 'date',
        'purchase_price' => 'decimal:2',
        'specifications' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function maintenanceLogs(): HasMany
    {
        return $this->hasMany(MaintenanceLog::class)->orderBy('maintenance_date', 'desc');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isInUse(): bool
    {
        return $this->status === 'in_use';
    }

    public function needsMaintenance(): bool
    {
        if (!$this->next_maintenance_date) {
            return false;
        }
        return $this->next_maintenance_date->isPast();
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'available' => 'green',
            'in_use' => 'blue',
            'maintenance' => 'orange',
            'retired' => 'gray',
            default => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'available' => 'Verfügbar',
            'in_use' => 'In Verwendung',
            'maintenance' => 'Wartung',
            'retired' => 'Ausgemustert',
            default => 'Unbekannt',
        };
    }
}
