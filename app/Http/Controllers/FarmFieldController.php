<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\FarmField;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

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
        // TODO: Check if the user meets the requirement to plant the crop.
        return response([
            'farmField' => $farmField,
            'crop' => $crop
        ]);
    }
}
