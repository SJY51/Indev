<?php

namespace App\Swagger\Auth\User;

/**
 * @OA\Schema(
 *     title="CreateUserRequest",
 *     description="Create User Request",
 *     required={"first_name", "last_name", "email", "phone", "password", "password_confirmation"},
 *     type="object",
 * )
 */
class CreateUserRequest
{
    /**
     * @OA\Property(
     *     property="first_name",
     *     description="First name.",
     *     type="string",
     *     example="Name"
     * )
     */
    public $first_name;

    /**
     * @OA\Property(
     *     property="last_name",
     *     description="Last name.",
     *     type="string",
     *     example="last name"
     * )
     */
    public $last_name;

    /**
     * @OA\Property(
     *     property="email",
     *     description="E-mail.",
     *     type="string",
     *     example="test@test.com"
     * )
     */
    public $email;

    /**
     * @OA\Property(
     *     property="phone",
     *     description="phone.",
     *     type="string",
     *     example="+3213212"
     * )
     */
    public $phone;

    /**
     * @OA\Property(
     *     property="password",
     *     description="Password.",
     *     type="string",
     *     example="123123123"
     * )
     */
    public $password;

    /**
     * @OA\Property(
     *     property="password_confirmation",
     *     description="Password confirmation. Must be identical to the password.",
     *     type="string",
     *     example="123123123"
     * )
     */
    public $password_confirmation;
}
