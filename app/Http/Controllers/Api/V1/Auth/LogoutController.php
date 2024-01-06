<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\V1\Controller;

class LogoutController extends Controller
{
    /**
     * @OA\Post(
     *     path="/v1/auth/logout",
     *     operationId="logout",
     *     tags={"Auth"},
     *     summary="Logout",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             example={
     *                 "message": "You have successfully logged out of Your account"
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             example={
     *                 "error": "Unauthorized"
     *             }
     *         )
     *     )
     * )
     *
     *
     * @param Request $request
     *
     * @return JsonResponse
     */



    public function __invoke(Request $request): JsonResponse
    {
        auth('api')->logout();

        return response()->json(['message' => 'You have successfully logged out of Your account']);
    }
}
