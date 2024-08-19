<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Seed extends Model
{
    use HasFactory;

    /**
     * Fields:
     *  id,
     *  name,
     *  image,
     *  seconds_to_grow_up,
     *  xp_reward,
     *  level_required_to_plant
     * TODO: Move seed_cost_at_market field to MarketProduct model to de-couple models.
     * TODO: Create Reward model to store data related to rewards such how many vegetables or
     * fruits are going to be rewarded upon harvest or side products etc.
     */
    protected $fillable = [
        'name',
        'image',
        'seconds_to_grow_up',
        'xp_reward',
        'level_required_to_plant'
    ];

    public function farmFields(): HasMany {
        return $this->hasMany(FarmField::class);
    }

    public function marketProduct(): MorphOne {
        return $this->morphOne(MarketProduct::class, 'marketable');
    }
}
