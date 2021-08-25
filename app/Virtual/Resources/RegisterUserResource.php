<?php
/**
 * @OA\Schema(
 *      title="Register user request",
 *      description="Register user request body data",
 *      type="object",
 *      required={"name","email","password"}
 * )
 */

class RegisterUserRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Names of the user",
     *      example="John Doe"
     * )
     *
     * @var string
     */
    public $name;

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