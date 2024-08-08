<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class ProfileController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array {
        return ['auth:sanctum'];
    }

    /**
     * Show the user data of the requesting user
     */
    public function show(Request $request) {
        $user = $request->user();

        return response($user);
    }
}
