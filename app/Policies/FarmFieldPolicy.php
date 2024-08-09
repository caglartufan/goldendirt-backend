<?php

namespace App\Policies;

use App\Enums\FarmFieldStatus;
use App\Models\Crop;
use App\Models\FarmField;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FarmFieldPolicy
{
    /**
     * Determine whether the user meet level requirement to plant the specified crop.
     */
    public function plant(User $user, FarmField $farmField, Crop $crop): Response
    {
        $response = Response::allow();

        if($user->id !== $farmField->user_id) {
            // TODO: Move these error messages to a message file. Below message
            // is also duplicated in FarmField model's binding logic.
            $response = Response::denyAsNotFound('Farm field was not found!');
        } elseif($farmField->status !== FarmFieldStatus::Idle) {
            $response = Response::denyWithStatus(400, 'Farm field is not available to plant crops.');
        } elseif($user->level < $crop->level_required_to_plant) {
            $response = Response::deny("You don't meet level requirement to plant this crop.");
        }

        return $response;
    }
}
