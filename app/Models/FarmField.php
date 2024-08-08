<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FarmField extends Model
{
    use HasFactory;

    protected $fillable = [
        'status'
    ];

    protected $attributes = [
        'status' => 'BARREN',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        // Validate that the farmField parameter is an integer between 1 and 18 inclusively.
        $validator = Validator::make(
            [
                'farmField' => $value
            ],
            [
                'farmField' => 'required|integer|min:1|max:18'
            ]
        );
        if($validator->fails()) {
            throw new NotFoundHttpException('Farm field was not found!');
        }

        $user = Auth::user();
        $farmField = $user->farmFields()->orderBy('id', 'asc')->skip($value - 1)->take(1)->first();
        
        return $farmField;
    }
}
