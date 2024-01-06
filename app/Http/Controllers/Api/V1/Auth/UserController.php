<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\User\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/v1/user",
     *     operationId="createUser",
     *     tags={"User"},
     *     summary="Create User",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/CreateUserRequest")
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *              example={
     *                  "user": {
     *                      "first_name": "Name",
     *                      "last_name": "second name",
     *                      "email": "test@test.com",
     *                      "phone": "+1111112",
     *                      "created_at": "2024-01-06T16:09:44.000000Z",
     *                      "updated_at": "2024-01-06T16:09:44.000000Z",
     *                      "id": 1,
     *                  }
     *              }
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *               example={
     *                   "error": "Unauthorized" ,
     *               }
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *               example={
     *                   "error": "Forbidden" ,
     *               }
     *          )
     *      ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *              example={
     *                  "message": "The password field confirmation does not match.",
     *                  "errors": {
     *                      "operator": {
     *                          "The password field confirmation does not match."
     *                      }
     *                  }
     *              }
     *          )
     *     )
     * )
     *
     * Create a new user.
     *
     * @param CreateUserRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreateUserRequest $request): JsonResponse
    {
        $requestData = $request->validated();

        $user = User::query()->create($requestData);

        return response()->json(['user' => $user], 201);
    }

}
