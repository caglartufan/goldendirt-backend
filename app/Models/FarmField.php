<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FarmField extends Model
{
    use HasFactory;

    protected $attributes = [
        'status' => 'BARREN',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
