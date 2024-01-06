<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/v1/auth/login",
     *     operationId="login",
     *     tags={"Auth"},
     *     summary="Authorisation",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"email", "password"},
     *             @OA\Property(
     *                 property="email",
     *                 description="E-mail.",
     *                 type="string",
     *                 example="test@test.com"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 description="Password.",
     *                 type="string",
     *                 example="123123123"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             example={
     *                 "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwNzkvYXBpL3YxL2F1dGgvbG9naW4iLCJpYXQiOjE3MDQ1NTc1MTEsImV4cCI6MTczNjA5MzUxMSwibmJmIjoxNzA0NTU3NTExLCJqdGkiOiJoTFdicnpvb21wQU1ibm5tIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.zo_hW7X1HAt8iPcJgDMGgECD_578G-cqZ-2dNxi_r88",
     *                 "token_type": "bearer",
     *                 "user_id": 1,
     *                 "expires_in": "525600",
     *                 "is_registration_completed": true
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *               example={
     *                  "error": "These credentials do not match our records",
     *               }
     *          )
     *      ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             example={
     *                 "message": "The password field confirmation does not match.",
     *                 "errors": {
     *                     "operator": {
     *                         "The password field confirmation does not match."
     *                     }
     *                 }
     *             }
     *         )
     *     )
     * )
     *
     * Authorisation.
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */


    public function __invoke(LoginRequest $request): JsonResponse
    {
        if (! $token = auth('api')->attempt($request->validated(), true)) {
            return response()->json(['error' => 'These credentials do not match our records'], 400);
        }

        return $this->respondWithToken($token);
    }
}
