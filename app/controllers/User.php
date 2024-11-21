<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User extends Controller {

    public function read() {
        $this->call->model('user_model');

        $query = isset($_GET['query']) ? $_GET['query'] : null;

        if ($query) {
            $data['prod'] = $this->user_model->searchUsers($query);
        } else {
            $data['prod'] = $this->user_model->readUsers();
        }
        $data['name'] = "User Management";
        $this->call->view('users/display', $data);
    }

    public function create() {
        if ($this->form_validation->submitted()) {
            $rrm_last_name = $this->io->post('last_name');
            $rrm_first_name = $this->io->post('first_name');
            $rrm_username = $this->io->post('username');
            $rrm_email = $this->io->post('email');
            $rrm_password = $this->io->post('password'); 
    
            $this->call->model('user_model');
    
            $createResult = $this->user_model->createUserWithCredentials(
                $rrm_username,
                $rrm_email,
                $rrm_password,
                $rrm_first_name,
                $rrm_last_name,
            );
    
            if ($createResult['success']) {
                // Redirect to login page after successful registration
                header("Location: /users/display?registered=true");
                exit;
            } else {
                $data['errorMessage'] = $createResult['message']; 
            }
        }
        $this->call->view('users/create'); 
    }
    

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

    public function send_email() {
        // This method handles the display of the email form
        $this->call->view('users/send_email'); // Ensure this view file exists
    }


    public function send_email_action() {
        // This method handles the form submission for sending the email
        $recipient_email = $this->io->post('recipient_email');
        $subject = $this->io->post('subject');
        $message = $this->io->post('message');
        $attachmentPath = $this->handleFileUpload(); // Handle the attachment

        // Handle email sending
        $this->call->library('email');
        $this->email->sender('reymelrey.mislang@gmail.com', 'Reymel Mislang');
        $this->email->recipient($recipient_email);
        $this->email->subject($subject);
        $this->email->email_content($message);

        // Attach the file if it exists
        if ($attachmentPath) {
            $this->email->attachment($attachmentPath);
        }

        if ($this->email->send()) {
            // Email sent successfully
            header("Location: /users/display?success=true");
        } else {
            // Email failed to send
            error_log('Email failed to send: ' . print_r($this->email->getErrors(), true));
            header("Location: /users/display?error=true");
        }
        exit;
    }
    private function handleFileUpload() {
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = 'C:/wamp64/www/rrmCrud/uploads/'; 
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $uploadFile = $uploadDir . basename($_FILES['attachment']['name']);
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadFile)) {
                return $uploadFile; 
            } else {
                error_log('Failed to move uploaded file.');
                return null;
            }
        }
        return null;
    }
    public function update($id) {
        $this->call->model('user_model');

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data['user'] = $this->user_model->getUserById($id); 

            if (!$data['user']) {
                header("Location: /users/display");
                exit;
            }

            $data['name'] = "Update User";
            $this->call->view('users/update', $data);
        } else if ($this->form_validation->submitted()) {
            $rrm_username = $this->io->post('username');
            $rrm_last_name = $this->io->post('last_name');
            $rrm_first_name = $this->io->post('first_name');
            $rrm_email = $this->io->post('email');
            $rrm_gender = $this->io->post('gender');
            $rrm_address = $this->io->post('address');
            $this->user_model->updateUsers($id, $rrm_last_name, $rrm_first_name, $rrm_username, $rrm_email, $rrm_gender, $rrm_address);
            header("Location: /users/display?updated=true");
            exit;
        }
    }

    public function delete($id) {
        $this->call->model('user_model');
        $this->user_model->deleteUsers($id);
        header("Location: /users/display?deleted=true");
        exit;
    }

    public function display() {
        $this->call->model('user_model'); 
        $totalEntries = $this->user_model->countUsers();
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $itemsPerPage = 5;
        $totalPages = ceil($totalEntries / $itemsPerPage);
        $offset = ($currentPage - 1) * $itemsPerPage;
        $users = $this->user_model->getUsersForPage($offset, $itemsPerPage); 
        $name = "Read User";

        $data = [
            'prod' => $users,
            'currentPage' => $currentPage,
            'itemsPerPage' => $itemsPerPage,
            'totalEntries' => $totalEntries,
            'totalPages' => $totalPages,
            'name' => $name,
            'successMessage' => isset($_GET['added']) && $_GET['added'] == 'true' ? 'User added successfully!' : null // Add success message
        ];

        $this->call->view('users/display', $data);
    }

    public function logout() {
        // Destroy session data
        session_start();
        session_destroy();
    
        // Redirect to the login page
        header("Location: /users/login");
        exit;
    }
    
}
