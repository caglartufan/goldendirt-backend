<?php

namespace App\Http\Controllers;

use App\Enums\FarmFieldStatus;
use App\Models\Crop;
use App\Models\FarmField;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Gate;

class FarmFieldController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return ['auth:sanctum'];
    }

    /**
     * Retrieve a list of all FarmFields of the user
     */
    public function list(Request $request)
    {
        $user = $request->user();
        $farmFields = $user->farmFields()->orderBy('id', 'asc')->get();

        return response($farmFields);
    }

    /**
     * Retrieve the Nth FarmField of the user
     */
    public function get(FarmField $farmField)
    {
        // TODO: Consider implementing rate-limiting to these requests
        return response($farmField);
    }

    /**
     * Plant the specified Crop to the Nth FarmField of the user
     * and checks if they are eligible to plant the crop
     */
    public function plant(FarmField $farmField, Crop $crop)
    {
        // Associate farmField instance with the crop instance
        $farmField->crop()->associate($crop);
        // Update the status, planted_at and harvestable_at columns of farmField
        $farmField->status = FarmFieldStatus::CropGrowingUp;
        $farmField->planted_at = now();
        $farmField->harvestable_at = now()->addSeconds($crop->seconds_to_grow_up);

        $farmField->save();

        // TODO: Dispatch a job that updates farmField's status to "CROP_GROWN_UP"
        // pushes an appropriate message to Redis database that needs to be
        // caught from Socket.io's Redis listener and emits an event to the client
        // to inform that the farmField of that user is harvestable

        // Returned farmField data also contains "crop" field which contains the crop data
        return response($farmField);
    }
}
