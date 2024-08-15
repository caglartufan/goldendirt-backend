<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_of_slots',
        'number'
    ];

    protected $attributes = [
        'number_of_slots' => 20
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function slots(): HasMany {
        return $this->hasMany(WarehouseSlot::class);
    }
}
