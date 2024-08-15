<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Utils\PlayerLevel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The accessors to append to the model's array and JSON serialized form.
     *
     * @var array
     */
    protected $appends = [
        'current_xp',
        'xp_required_for_next_level'
    ];

    /**
     * Determine the current xp progression of the user
     */
    protected function currentXp(): Attribute {
        return new Attribute(
            get: function() {
                $xpRequiredToLevelUp = PlayerLevel::calculateXpRequiredForLevelUp($this->total_xp);
                $xpRequiredForNextLevel = PlayerLevel::getXpRequiredForLevel($this->level + 1);
                
                return $xpRequiredForNextLevel - $xpRequiredToLevelUp;
            }
        );
    }

    /**
     * Determine the xp required to level up for the user
     */
    protected function xpRequiredForNextLevel(): Attribute {
        return new Attribute(
            get: fn() => PlayerLevel::getXpRequiredForLevel($this->level + 1)
        );
    }

    public function farmFields(): HasMany {
        return $this->hasMany(FarmField::class);
    }

    public function warehouses(): HasMany {
        return $this->hasMany(Warehouse::class);
    }

    public function warehouseSlots(): HasManyThrough {
        return $this->throughWarehouses()->hasSlots();
    }
}
