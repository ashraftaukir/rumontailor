<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    /**
     * Get the orders for the customer.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the measurements for the customer.
     */
    public function measurements(): HasMany
    {
        return $this->hasMany(CustomerMeasurement::class);
    }

    /**
     * Get measurement for a specific garment type.
     */
    public function getMeasurementByType(string $garmentType): ?CustomerMeasurement
    {
        return $this->measurements()->where('garment_type', $garmentType)->first();
    }
}
