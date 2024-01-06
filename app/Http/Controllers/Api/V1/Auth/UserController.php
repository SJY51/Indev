<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\User\CreateUserRequest;
use App\Http\Requests\V1\Auth\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/v1/user/{id}",
     *     operationId="GetUser",
     *     tags={"User"},
     *     summary="Get user information",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User id.",
     *         example=1,
     *         required=false,
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             example={
     *                 "user": {
     *                     "id": 1,
     *                     "first_name": "Name",
     *                     "last_name": "second name",
     *                     "email": "test@test.com",
     *                     "phone": "+1111112",
     *                     "created_at": "2024-01-06T16:09:44.000000Z",
     *                     "updated_at": "2024-01-06T16:09:44.000000Z",
     *                 }
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
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             example={
     *                 "error": "Forbidden"
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             example={
     *                 "error": "User not found"
     *             }
     *         )
     *     )
     * )
     *
     * My data.
     *
     * @return JsonResponse
     */
    public function get($id = null): JsonResponse
    {
        if(!UserHelper::isCurrentUserOrHasAccess($id,'get users')){
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $user = User::query()->findOrFail($id);

        return response()->json(['user' => $user], 201);
    }


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
     * @param  CreateUserRequest  $request
     *
     * @return JsonResponse
     */
    public function create(CreateUserRequest $request): JsonResponse
    {
        $requestData = $request->validated();

        $user = User::query()->create($requestData);

        return response()->json(['user' => $user], 201);
    }

    /**
     * @OA\Put(
     *     path="/v1/user/{id}",
     *     operationId="updateUser",
     *     tags={"User"},
     *     summary="Update User",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User id.",
     *         example=1,
     *         required=false,
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/UpdateUserRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
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
     * Update a user.
     *
     * @param  UpdateUserRequest  $request
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, $id = null): JsonResponse
    {
        $id = UserHelper::getUserId($id);

        $user = User::query()->whereNull('deleted_at')->findOrFail($id);

        $requestData = $request->validated();
        $user->update($requestData);

        return response()->json(['user' => $user], 200);
    }



    /**
     * @OA\Delete(
     *     path="/v1/user/{id}",
     *     operationId="deleteUser",
     *     tags={"User"},
     *     summary="Delete user",
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="User id.",
     *          example=1,
     *          required=false,
     *          @OA\Schema(type="number")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             example={
     *                 "message": "User deleted successfully"
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
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             example={
     *                 "error": "Forbidden"
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             example={
     *                 "error": "User not found"
     *             }
     *         )
     *     )
     * )
     *
     * My data.
     *
     * @return JsonResponse
     */
    public function delete($id = null): JsonResponse
    {
        $id = UserHelper::getUserId($id);

        $user = User::query()->whereNull('deleted_at')->findOrFail($id);

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }


}
