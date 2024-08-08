<?php

use App\Models\User;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * This function generates a Personal Access Token (PAT) for given user
 * and then returns a Cookie object to be set on the response header.
 * This PAT is specifically named Primary and used to interact with REST API
 * from the Socket.io websocket server.
 */
function generatePrimaryApiTokenAndCookieForUser(User $user): Cookie {
  $token = $user->tokens()->where('name', 'Primary');

  if($token) {
      $token->delete();
  }

  $token = $user->createToken('Primary');

  return cookie(
      'api_token',
      $token->plainTextToken,
      90 * 24 * 60, // 90 days
      env('SESSION_PATH', '/'),
      env('SESSION_DOMAIN'),
      env('SESSION_SECURE_COOKIE'),
      env('SESSION_HTTP_ONLY', true),
      false,
      env('SESSION_SAME_SITE', 'lax')
  );
}
