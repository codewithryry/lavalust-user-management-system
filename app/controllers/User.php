<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User extends Controller {

    public function read() {
        $this->call->model('user_model');

        // Check if there is a search query
        $query = isset($_GET['query']) ? $_GET['query'] : null;

        if ($query) {
            // If there is a search query, fetch users based on it
            $data['prod'] = $this->user_model->searchUsers($query);
        } else {
            // If no search query, fetch all users
            $data['prod'] = $this->user_model->readUsers();
        }
        $data['name'] = "User List";
        $this->call->view('users/display', $data);
    }

    public function create() {
        if ($this->form_validation->submitted()) {
            // Capture input values
            $rrm_last_name = $this->io->post('last_name');
            $rrm_first_name = $this->io->post('first_name');
            $rrm_username = $this->io->post('username');
            $rrm_email = $this->io->post('email');
            $rrm_gender = $this->io->post('gender');
            $rrm_address = $this->io->post('address');
            $rrm_password = $this->io->post('password'); // Capture password

            // Handle file upload
            $attachmentPath = $this->handleFileUpload(); // Method to handle file uploads

            $this->call->model('user_model');

            // Call the method to create a user with all parameters
            $createResult = $this->user_model->createUserWithCredentials(
                $rrm_username,
                $rrm_email,
                $rrm_password,
                $rrm_first_name,
                $rrm_last_name,
                $rrm_gender,
                $rrm_address
            );

            // Debugging: Log the result of the user creation
            error_log("Create Result: " . print_r($createResult, true)); // Log the result

            if ($createResult['success']) {
                $this->call->library('email');
                $this->email->sender('reymelrey.mislang@gmail.com', 'Reymel Mislang');
                $this->email->recipient($rrm_email);
                $this->email->subject("Registration Successful");
                $this->email->email_content("Dear $rrm_first_name $rrm_last_name,\n\nThank you for registering with our User Management System! We're excited to have you on board.\n\nYour account has been successfully created, and you can now log in to manage your user information easily.\n\nBest Regards,\nCodeWithRyRy@Team ");
            
                
                // Add attachment if exists
                if ($attachmentPath) {
                    $this->email->attachment($attachmentPath);
                }

                // Attempt to send the email
                if (!$this->email->send()) {
                    error_log('Email failed to send: ' . print_r($this->email->getErrors(), true));
                }

                header("Location: /users/login?added=true");
                exit;
            } else {
                // Log the error message for debugging
                error_log("User creation failed: " . $createResult['message']); // Log the error message
                $data['errorMessage'] = $createResult['message']; // Display the error message
            }
        }
        $this->call->view('users/create'); 
    }

    public function login() {
        $data = [];

        if ($this->form_validation->submitted()) {
            $rrm_username = $this->io->post('username');
            $rrm_password = $this->io->post('password');

            // Debug: Check values before login
            error_log("Username: $rrm_username");
            error_log("Password: $rrm_password");

            $this->call->model('user_model');
            $loginResult = $this->user_model->loginUser($rrm_username, $rrm_password);

            // Debug: Check login result
            error_log(print_r($loginResult, true));

            if ($loginResult['success']) {
                session_start(); // Start the session
                $_SESSION['username'] = $loginResult['user']['rrm_username']; // Store user info in session
                header("Location: /users/display"); // Redirect to user.display on successful login
                exit;
            } else {
                $data['errorMessage'] = $loginResult['message']; // Display the error message
            }
        }

        // Pass the error message to the view
        $this->call->view('users/login', $data);
    }

    private function handleFileUpload() {
        // Check if a file has been uploaded
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = 'C:/wamp64/www/rrmCrud/uploads/'; // Specify your upload directory
            // Ensure the directory exists, create it if it doesn't
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $uploadFile = $uploadDir . basename($_FILES['attachment']['name']);

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadFile)) {
                return $uploadFile; // Return the path of the uploaded file
            } else {
                error_log('Failed to move uploaded file.');
                return null; // Return null if the file upload fails
            }
        }
        return null; // No file uploaded
    }

    // Update User
    public function update($id) {
        $this->call->model('user_model'); // Load the model

        // Fetch user data if it's a GET request to pre-fill the form
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data['user'] = $this->user_model->getUserById($id); // Fetch user by ID

            // Check if user exists
            if (!$data['user']) {
                // Handle user not found
                header("Location: /users/display");
                exit; // Redirect if user not found
            }

            $data['name'] = "Update User";
            $this->call->view('users/update', $data);
        } else if ($this->form_validation->submitted()) { // If form is submitted
            // Capture input values including username
            $rrm_username = $this->io->post('username');
            $rrm_last_name = $this->io->post('last_name');
            $rrm_first_name = $this->io->post('first_name');
            $rrm_email = $this->io->post('email');
            $rrm_gender = $this->io->post('gender');
            $rrm_address = $this->io->post('address');

            // Call the update method in user_model
            $this->user_model->updateUsers($id, $rrm_last_name, $rrm_first_name, $rrm_username, $rrm_email, $rrm_gender, $rrm_address);
            // Redirect to the display page with a success message
            header("Location: /users/display?updated=true");
            exit;
        }
    }

    // Delete User
    public function delete($id) {
        $this->call->model('user_model');
        $this->user_model->deleteUsers($id);
        // Redirect to the read page after deletion
        header("Location: /users/display?deleted=true");
        exit;
    }

    public function display() {
        $this->call->model('user_model'); // Load the model properly

        // Get the total number of users
        $totalEntries = $this->user_model->countUsers();

        // Get the current page number from the query string or default to 1
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Define how many items you want per page
        $itemsPerPage = 5; // Display 5 items per page

        // Calculate total pages
        $totalPages = ceil($totalEntries / $itemsPerPage);

        // Fetch the users for the current page
        $offset = ($currentPage - 1) * $itemsPerPage;
        $users = $this->user_model->getUsersForPage($offset, $itemsPerPage); // Adjusted to use offset

        // Define the page name
        $name = "Read User";

        // Pass the variables to the view
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
}
