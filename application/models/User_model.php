<?php
class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Register User
    public function register($data) {
        $clean_data = $this->security->xss_clean($data);
        return $this->db->insert('users', $clean_data);
    }

    // Login User
    public function login($email, $password) {
        $email = $this->security->xss_clean($email);
        
        $query = $this->db->get_where('users', array('email' => $email));

        if ($query->num_rows() > 0) {
            $user = $query->row();
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }

        return false;
    }

    // Fetch all users
    public function get_all_users() {
        return $this->db->get('users')->result();
    }

    // Get user by ID
    public function get_user_by_id($user_id) {
        return $this->db->where('id', $user_id)->get('users')->row();
    }

    // Check if username is taken (excluding a specific user)
    public function is_username_taken($username, $exclude_user_id = null) {
        $this->db->where('username', $username);
        if ($exclude_user_id) {
            $this->db->where('id !=', $exclude_user_id);
        }
        return $this->db->count_all_results('users') > 0;
    }

    // Check if email is taken (excluding a specific user)
    public function is_email_taken($email, $exclude_user_id = null) {
        $this->db->where('email', $email);
        if ($exclude_user_id) {
            $this->db->where('id !=', $exclude_user_id);
        }
        return $this->db->count_all_results('users') > 0;
    }

    // Update user data
    public function update_user($user_id, $data) {
        $clean_data = $this->security->xss_clean($data);
        $this->db->where('id', $user_id);
        return $this->db->update('users', $clean_data);
    }

    // Delete user
    public function delete_user($user_id) {
        $this->db->where('id', $user_id);
        $this->db->delete('users');
        return $this->db->affected_rows() > 0;
    }
}
