<?php

namespace App\Policies;

use App\Enums\FarmFieldStatus;
use App\Models\Seed;
use App\Models\FarmField;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FarmFieldPolicy
{
    /**
     * Determine whether the user meet level requirement to plant the specified crop.
     */
    public function plant(User $user, FarmField $farmField, Seed $seed): Response
    {
        $response = Response::allow();

        if($user->id !== $farmField->user_id) {
            // TODO: Move these error messages to a message file. Below message
            // is also duplicated in FarmField model's binding logic.
            $response = Response::denyAsNotFound(__('messages.farm_field.not_found'));
        } elseif($farmField->status !== FarmFieldStatus::Idle) {
            $response = Response::denyWithStatus(400, __('messages.farm_field.not_available_to_plant'));
        } elseif($user->level < $seed->level_required_to_plant) {
            $response = Response::deny(__('messages.farm_field.level_requirement_doesnt_meet'));
        }

        return $response;
    }
}
