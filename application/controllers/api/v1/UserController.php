<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper(['form', 'url']);
        $this->load->library(['form_validation', 'session']);
    }

        /**
     * @OA\GET(
     *     path="GET/api/v1/users/{enccode}",
     *     summary="This will post the User Name, Email, Password of the User",
     *     tags={"Registration"},
     *     @OA\Response(
     *         response="404",
     *         description="Username is already taken."
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Email is already registered."
     *     ),     
     *      @OA\Response(
     *         response="202",
     *         description="Registration successful! Please log in."
     *     ),
     *      @OA\Response(
     *         response="403",
     *         description="Registration failed. Try again.."
     *     ),
     *      security={{"basicAuth": {}}}
     * )
     */
    public function register() {

    }

              /**
     * @OA\POST(
     *     path="POST/api/v1/users{enccode}",
     *     summary="This will post the Username and  Email",
     *     tags={"Users"},
     *     @OA\Response(
     *         response="401",
     *         description="Invalid email or password."
     *     ), 
     *      security={{"basicAuth": {}}}
     * )
     */

                   /**
     * @OA\PATCH(
     *     path="PATCH/api/v1/users/id{enccode}",
     *     summary="This will update the Username and  Email",
     *     tags={"Users"},
     *     @OA\Response(
     *         response="409",
     *         description="Username or Email already exists!"
     *     ),
     *    @OA\Response(
     *         response="500",
     *         description="Failed to update user!"
     *     ), 
     *      security={{"basicAuth": {}}}
     * )
     */

     
     /**
     * @OA\DELETE(
     *     path="DELETE/api/v1/users/id{enccode}",
     *     summary="This will delete the User",
     *     tags={"Users"},
     *     @OA\Response(
     *         response="204",
     *         description="Success!"
     *     ),
     *    @OA\Response(
     *         response="404",
     *         description="Failed to delete user!"
     *     ), 
     *      security={{"basicAuth": {}}}
     * )
     */
    public function login() {

    }

}
