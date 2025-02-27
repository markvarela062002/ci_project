<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper('url');
        $this->load->library('session');

        // Redirect to login if user is not authenticated
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['users'] = $this->User_model->get_all_users(); // Fetch user list
        $this->load->view('dashboard', $data);
    }

    // Update User Username and Email
    public function update_user() {
        $userId = $this->input->post('user_id');
        $newUsername = $this->input->post('username');
        $newEmail = $this->input->post('email');
    
        if (empty($userId) || empty($newUsername) || empty($newEmail)) {
            echo json_encode(["status" => "error", "message" => "All fields are required!"]);
            return;
        }
    
        // Check if the username or email already exists for another user
        $this->db->where('id !=', $userId);
        $this->db->where("(username = '$newUsername' OR email = '$newEmail')");
        $existingUser = $this->db->get('users')->row();
    
        if ($existingUser) {
            echo json_encode(["status" => "error", "message" => "Username or Email already exists!"]);
            return;
        }
    
        // Update user in the database
        $this->db->where('id', $userId);
        $update = $this->db->update('users', ['username' => $newUsername, 'email' => $newEmail]);
    
        if ($update) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update user!"]);
        }
    }
    

    // Delete User
    public function delete_user() {
        $user_id = $this->input->post('user_id');

        if (!$user_id) {
            echo json_encode(["status" => "error", "message" => "Invalid user ID"]);
            return;
        }

        $deleted = $this->User_model->delete_user($user_id);

        if ($deleted) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete user"]);
        }
    }

    // Change Password with Current Password Verification
    public function change_password() {
        $user_id = $this->input->post('user_id');
        $current_password = trim($this->input->post('current_password'));
        $new_password = trim($this->input->post('new_password'));
        $confirm_password = trim($this->input->post('confirm_password'));

        // Ensure user is only changing their own password
        if ($user_id != $this->session->userdata('user_id')) {
            echo json_encode(["status" => "error", "message" => "Unauthorized action!"]);
            return;
        }

        // Validate required fields
        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            echo json_encode(["status" => "error", "message" => "All fields are required!"]);
            return;
        }

        // Fetch current hashed password from the database
        $this->db->where('id', $user_id);
        $user = $this->db->get('users')->row();

        if (!$user) {
            echo json_encode(["status" => "error", "message" => "User not found!"]);
            return;
        }

        // Verify the current password
        if (!password_verify($current_password, $user->password)) {
            echo json_encode(["status" => "error", "message" => "Current password is incorrect!"]);
            return;
        }

        // Check if new password matches confirmation
        if ($new_password !== $confirm_password) {
            echo json_encode(["status" => "error", "message" => "New passwords do not match!"]);
            return;
        }

        // Prevent using the same password again
        if (password_verify($new_password, $user->password)) {
            echo json_encode(["status" => "error", "message" => "New password cannot be the same as the current password!"]);
            return;
        }

        // Ensure password length is at least 6 characters
        if (strlen($new_password) < 6) {
            echo json_encode(["status" => "error", "message" => "Password must be at least 6 characters long!"]);
            return;
        }

        // Hash the new password before saving
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password in the database
        $this->db->where('id', $user_id);
        $this->db->update('users', ['password' => $hashed_password]);

        if ($this->db->affected_rows() > 0) {
            echo json_encode(["status" => "success", "message" => "Password updated successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update password."]);
        }
    }
}
