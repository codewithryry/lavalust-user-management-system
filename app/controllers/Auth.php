<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Auth extends Controller {

    public function login() {
        $data = [];
    
        if ($this->form_validation->submitted()) {
            $rrm_username = $this->io->post('username');
            $rrm_password = $this->io->post('password');
    
            $this->call->model('user_model');
            $loginResult = $this->user_model->loginUser($rrm_username, $rrm_password);
    
            if ($loginResult['success']) {
                session_start(); 
                $_SESSION['username'] = $loginResult['user']['rrm_username']; 
                $_SESSION['email'] = $loginResult['user']['rrm_email']; // Store email in session
    
                // Redirect to the send email form after successful login
                header("Location: /users/send_email");
                exit;
            } else {
                $data['errorMessage'] = $loginResult['message']; 
            }
        }
    
        $this->call->view('users/login', $data);
    }

    public function reset_password() {
        $data = [];
    
        if ($this->form_validation->submitted()) {
            $email = $this->io->post('email');
    
            $this->call->model('user_model');
            $result = $this->user_model->sendPasswordReset($email);
    
            if ($result['success']) {
                // Retrieve user ID
                $user = $this->user_model->getUserByEmail($email);
                if ($user) {
                    $userId = $user['id'];
                    // Send email with reset instructions
                    $this->sendPasswordResetEmail($email, $userId);
                    $data['successMessage'] = 'Please check your email for instructions to reset your password.';
                } else {
                    $data['errorMessage'] = 'No user found with that email address.';
                }
            } else {
                $data['errorMessage'] = $result['message'];
            }
        }
    
        $this->call->view('auth/reset_password', $data);
    }
    public function reset_password_action($id) {
        error_log("Reset password action triggered for user ID: $id"); // Debugging line
        $data = [];
        $data['userId'] = $id; // Store the user ID in the data array
    
        if ($this->form_validation->submitted()) {
            $newPassword = $this->io->post('new_password');
            $confirmPassword = $this->io->post('confirm_password');
    
            if ($newPassword === $confirmPassword) {
                // Reset password using the user ID
                $this->call->model('user_model');
                $result = $this->user_model->resetPassword($id, $newPassword);
    
                // Debugging output
                error_log("Reset Password Result: " . print_r($result, true));
    
                if (is_array($result) && isset($result['success']) && $result['success']) {
                    // Get the user's email to send confirmation
                    $user = $this->user_model->getUserById($id); // Get user info by ID
                    if ($user) {
                        $this->sendPasswordConfirmationEmail($user['rrm_email']); // Send confirmation email
                    }
                    
                    // Set success message
                    $data['successMessage'] = 'Your password has been reset successfully!'; // Set the success message
    
                    // Render the view without the form
                    $this->call->view('auth/reset_password_action', $data);
                    exit; // End execution after rendering the view
                } else {
                    // If the result is not as expected, handle the error
                    $data['errorMessage'] = is_array($result) ? $result['message'] : 'An unexpected error occurred.';
                }
            } else {
                $data['errorMessage'] = 'Passwords do not match.';
            }
        }
    
        // Pass the data array including userId to the view if not submitted
        $this->call->view('auth/reset_password_action', $data);
    }
    
    
        private function sendPasswordResetEmail($recipient_email, $userId) {
        $subject = 'Password Reset Request';
        
        // Dynamically create the reset link with the actual user ID
        $resetLink = "http://localhost:8081/auth/reset_password_action/$userId"; 

        // Message content with the link
        $message = "Click the link to reset your password: <a href=\"$resetLink\">Reset Password</a>";
    
        // Using HTML in the email
        $this->call->library('email');
        $this->email->sender('reymelrey.mislang@gmail.com', 'Reymel Mislang');
        $this->email->recipient($recipient_email);
        $this->email->subject($subject);
        $this->email->email_content($message);
        
        if (!$this->email->send()) {
            error_log('Email failed to send: ' . print_r($this->email->getErrors(), true));
        }
    }
    
    private function sendPasswordConfirmationEmail($recipient_email) {
        $subject = 'Password Reset Confirmation';
        $message = 'Your password has been successfully reset.';

        $this->call->library('email');
        $this->email->sender('reymelrey.mislang@gmail.com', 'Reymel Mislang');
        $this->email->recipient($recipient_email);
        $this->email->subject($subject);
        $this->email->email_content($message);

        if (!$this->email->send()) {
            error_log('Email failed to send: ' . print_r($this->email->getErrors(), true));
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /users/login");
        exit;
    }
}
