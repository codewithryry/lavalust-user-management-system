<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User_model extends Model {

    // Retrieve all users
    public function readUsers() {
        return $this->db->table('rrm_users')->get_all();
    }

    // Create a new user with details including username, email, and hashed password
    public function createUsers($rrm_last_name, $rrm_first_name, $rrm_username, $rrm_email, $password) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Prepare data
        $data = array(
            'rrm_last_name'  => $rrm_last_name,
            'rrm_first_name' => $rrm_first_name,
            'rrm_username'   => $rrm_username,
            'rrm_email'      => $rrm_email,
            'rrm_password'   => $hashed_password, // Add password field
        );
        return $this->db->table('rrm_users')->insert($data);
    }

    // Update user information including username
    public function updateUsers($id, $rrm_last_name, $rrm_first_name, $rrm_username, $rrm_email, $rrm_gender, $rrm_address) {
        $data = array(
            'rrm_last_name'  => $rrm_last_name,
            'rrm_first_name' => $rrm_first_name,
            'rrm_username'   => $rrm_username,
            'rrm_email'      => $rrm_email,
            'rrm_gender'     => $rrm_gender,
            'rrm_address'    => $rrm_address
        );
        return $this->db->table('rrm_users')->where('id', $id)->update($data);
    }

    // Delete a user by ID
    public function deleteUsers($id) {
        return $this->db->table('rrm_users')->where('id', $id)->delete();
    }

    // Get a user by ID
    public function getUserById($id) {
        return $this->db->table('rrm_users')->where('id', $id)->get();
    }

    // Validate user credentials based on username and password
    public function validateUser($rrm_username, $password) {
        $user = $this->db->table('rrm_users')->where('rrm_username', $rrm_username)->get();
        if ($user && password_verify($password, $user['rrm_password'])) {
            return $user;
        }
        return false;
    }

    // Create a new user (this method can be removed if createUsers is used)
    public function createUser($rrm_username, $password, $rrm_email) {
        // Check if the user already exists
        $existingUser = $this->db->table('rrm_users')->where('rrm_username', $rrm_username)->get();
        if ($existingUser) {
            return false; // User already exists
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $data = array(
            'rrm_username' => $rrm_username,
            'rrm_password' => $hashed_password,
            'rrm_email'    => $rrm_email
        );
        return $this->db->table('rrm_users')->insert($data);
    }

    // Create a new user with credentials
    public function createUserWithCredentials($rrm_username, $rrm_email, $rrm_password, $rrm_first_name, $rrm_last_name) {
        // Check if the username or email already exists
        if ($this->db->table('rrm_users')->where('rrm_username', $rrm_username)->get()) {
            return ['success' => false, 'message' => 'Username already exists.'];
        }
    
        if ($this->db->table('rrm_users')->where('rrm_email', $rrm_email)->get()) {
            return ['success' => false, 'message' => 'Email already exists.'];
        }
    
        // Hash the password for security
        $hashed_password = password_hash($rrm_password, PASSWORD_BCRYPT);
    
        // Prepare data
        $data = array(
            'rrm_username'  => $rrm_username,
            'rrm_email'     => $rrm_email,
            'rrm_password'  => $hashed_password,
            'rrm_first_name' => $rrm_first_name,
            'rrm_last_name'  => $rrm_last_name,
        );
            if ($this->db->table('rrm_users')->insert($data)) {
            return ['success' => true]; 
        } else {
            error_log('Database insert error: ' . print_r($this->db->getLastError(), true));
            return ['success' => false, 'message' => 'Error creating user.'];
        }
    }
    
    public function loginUser($rrm_username, $password) {
        $user = $this->validateUser($rrm_username, $password);
        if ($user) {
            return ['success' => true, 'user' => $user];
        }
        return ['success' => false, 'message' => 'Invalid username or password.'];
    }
}
?>
