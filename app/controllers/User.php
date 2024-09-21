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
            $rrm_last_name = $this->io->post('last_name');
            $rrm_first_name = $this->io->post('first_name');
            $rrm_email = $this->io->post('email');
            $rrm_gender = $this->io->post('gender');
            $rrm_address = $this->io->post('address');

            $this->call->model('user_model');
            $this->user_model->createUsers($rrm_last_name, $rrm_first_name, $rrm_email, $rrm_gender, $rrm_address);
            // Redirect after creation with success message
            header("Location: /users/display?added=true");
            exit;
        }
        $this->call->view('users/create'); 
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
            $rrm_last_name = $this->io->post('last_name');
            $rrm_first_name = $this->io->post('first_name');
            $rrm_email = $this->io->post('email');
            $rrm_gender = $this->io->post('gender');
            $rrm_address = $this->io->post('address');
    
            // Call the update method in user_model
            $this->user_model->updateUsers($id, $rrm_last_name, $rrm_first_name, $rrm_email, $rrm_gender, $rrm_address);
            // Redirect to the display page with a success message
            header("Location: /users/display?updated=true");
            exit;
        }
    }
    

    // Delete User
// In your delete method in the controller
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
?>
