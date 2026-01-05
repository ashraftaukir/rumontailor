<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerMeasurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'garment_type',
        'chest', 'waist', 'shoulder_width', 'sleeve_length', 'shirt_length', 'jacket_length',
        'neck', 'armhole', 'bicep', 'wrist', 'hip', 'inseam', 'outseam',
        'thigh', 'knee', 'ankle', 'pant_length',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'chest' => 'decimal:2',
            'waist' => 'decimal:2',
            'shoulder_width' => 'decimal:2',
            'sleeve_length' => 'decimal:2',
            'shirt_length' => 'decimal:2',
            'jacket_length' => 'decimal:2',
            'neck' => 'decimal:2',
            'armhole' => 'decimal:2',
            'bicep' => 'decimal:2',
            'wrist' => 'decimal:2',
            'hip' => 'decimal:2',
            'inseam' => 'decimal:2',
            'outseam' => 'decimal:2',
            'thigh' => 'decimal:2',
            'knee' => 'decimal:2',
            'ankle' => 'decimal:2',
            'pant_length' => 'decimal:2',
        ];
    }

    /**
     * Get the customer that owns the measurement.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
