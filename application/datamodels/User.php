<?php

/**
 * @OA\Schema(
 *     title="User model",
 *     description="User model",
 * )
 */
class User
{
    /**
     * @OA\Property(description="ID",title="ID")
     * @var int
     */
    private $id;

    /**
     * @OA\Property(description="Username",title="Username")
     * @var string
     */
    private $username;

    /**
     * @OA\Property(description="Email", title="Email")
     * @var string
     */
    private $email;

    /**
     * @OA\Property(description="Password",title="Password")
     * @var string
     */
    private $password;

        /**
     * @OA\Property(description="Date Created",title="Date Created")
     * @var int
     */
    private $created_at;
}