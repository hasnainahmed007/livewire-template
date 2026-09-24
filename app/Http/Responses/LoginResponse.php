<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): Response
    {
        $user = $request->user();

        if ($user) {
            return redirect()->intended(route($user->dashboardRoute(), absolute: false));
        }

        return redirect()->intended(config('fortify.home', '/dashboard'));
    }
}
