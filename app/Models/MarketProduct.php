<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MarketProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'price'
    ];

    public function marketable(): MorphTo {
        return $this->morphTo();
    }
}
