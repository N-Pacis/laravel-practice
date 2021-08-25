<?php
/**
 * @OA\Schema(
 *      title="Login user request",
 *      description="Login user request body data",
 *      type="object",
 *      required={"email","password"}
 * )
 */

class LoginUserRequest
{
    /**
     * @OA\Property(
     *      title="email",
     *      description="Email of the user",
     *      example="abcdef@gmail.com"
     * )
     *
     * @var string
     */
    public $email;
  
    /**
     * @OA\Property(
     *      title="password",
     *      description="Password of the user",
     *      example="abcdef123.com"
     * )
     *
     * @var string
     */
    public $password;
}