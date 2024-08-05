<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        // TODO: Send the same cookie upon sign-up in RegisteredUserController
        $user = $request->user();
        $token = $user->tokens()->where('name', 'Primary');

        if($token) {
            $token->delete();
        }

        $token = $user->createToken('Primary');

        $apiTokenCookie = cookie(
            'api_token',
            $token->plainTextToken,
            90 * 24 * 60,
            env('SESSION_PATH', '/'),
            env('SESSION_DOMAIN'),
            env('SESSION_SECURE_COOKIE'),
            env('SESSION_HTTP_ONLY', true),
            false,
            env('SESSION_SAME_SITE', 'lax')
        );

        return response()->noContent()->cookie($apiTokenCookie);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
