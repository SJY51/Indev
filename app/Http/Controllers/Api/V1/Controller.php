<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="InDev",
 *     description="InDev API documentation"
 * )
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="InDev OpenApi dynamic host server"
 * )
 * @OA\Tag(
 *     name="Auth",
 *     description="Registration and authorisation."
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     in="header",
 *     name="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Token"
 * )
 */
class Controller extends BaseController
{
    /**
     * Get the token array structure.
     *
     * @param  string  $token
     *
     * @return JsonResponse
     */
    public function respondWithToken(string $token, $is_registration_completed = true): JsonResponse
    {
        auth('api')->setToken($token);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user_id' => auth('api')->user()->id,
            'expires_in' => auth('api')->factory()->getTTL(),
            'is_registration_completed' => $is_registration_completed,
        ]);
    }
}
