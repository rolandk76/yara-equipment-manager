<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceLog extends Model
{
    protected $fillable = [
        'equipment_id',
        'performed_by',
        'type',
        'maintenance_date',
        'description',
        'cost',
        'duration_minutes',
        'next_maintenance_date',
        'notes',
        'parts_replaced',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
        'cost' => 'decimal:2',
        'parts_replaced' => 'array',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function performedBy(): BelongsTo
    {
        return $this->setConnection('shared')
            ->belongsTo(User::class, 'performed_by');
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'routine' => 'Routinewartung',
            'repair' => 'Reparatur',
            'inspection' => 'Inspektion',
            'calibration' => 'Kalibrierung',
            default => 'Unbekannt',
        };
    }
}
