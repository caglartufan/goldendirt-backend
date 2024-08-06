<?php

use App\Models\User;
use Symfony\Component\HttpFoundation\Cookie;

function generatePrimaryApiTokenAndCookieForUser(User $user): Cookie {
  $token = $user->tokens()->where('name', 'Primary');

  if($token) {
      $token->delete();
  }

  $token = $user->createToken('Primary');

  return cookie(
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
}
