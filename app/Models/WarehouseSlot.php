<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class WarehouseSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity'
    ];

    public function warehouse(): BelongsTo {
        return $this->belongsTo(Warehouse::class);
    }

    public function storable(): MorphTo {
        return $this->morphTo();
    }
}
