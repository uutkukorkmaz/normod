<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class AuthenticatedSessionController extends Controller
{
    /**
     * @OA\PathItem(
     *     path="/api/login"
     * )
     *
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Login",
     *     description="Login",
     *     operationId="login",
     *     @OA\RequestBody(
     *     description="Login",
     *     required=true,
     *     @OA\JsonContent(
     *     required={"email","password"},
     *     @OA\Property(property="email", type="string", format="email", example="test@example.com"),
     *     @OA\Property(property="password", type="string", format="password", example="password"),
     *     ),
     *     ),
     *     @OA\Response(
     *     response=204,
     *     description="Successful operation",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(
     *     property="message",
     *     type="string",
     *     description="The error message",
     *     example="No Content"
     *    )
     *  )
     * ),
     *     @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(
     *     property="message",
     *     type="string",
     *     description="The error message",
     *     example="Unauthenticated."
     *   )
     * )
     * )
     * )
     *
     *
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
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
