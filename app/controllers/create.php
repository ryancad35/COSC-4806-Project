<?php

class Create extends Controller {

    public function index() {		
        // Redirect to index.php if user is already logged in
        if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
            header('Location: /home');
            exit();
        }

        $error = '';
        $username = '';

        $action = filter_input(INPUT_POST, 'action');
        if ($action === null) {
            $action = filter_input(INPUT_GET, 'action');
        }

        // Check if user has clicked on the submit button
        if ($action === 'Submit Registration') {
            $username = trim(filter_input(INPUT_POST, 'username'));
            $password = trim(filter_input(INPUT_POST, 'password'));

            $userObj = $this->model('User');

            // Check if fields are empty
            if (! $userObj->notEmptyAccount($username, $password)) {
                $error = 'Username and password cannot be empty.';
            }
            // Check if password is at least 10 characters long
            elseif (strlen($password) < 10) {
                $error = 'Password must be at least 10 characters long.';
            }
            // At this point, both fields are not empty and password is at least 10 characters long
            else {

                // Check if username already exists
                if (! $userObj->checkUsername($username)) {
                    $error = 'That username is already taken. Please choose another.';
                }
                else {
                    // Username does not exist, create new user
                    $newUserId = $userObj->create_user($username, $password);
                    if ($newUserId) {
                        // Instead of redirecting immediately, set success message
                        $success = 'Account successfully created! <a href="/login">Click here to login</a>.';
                        // Clear username so form is empty
                        $username = '';
                    } else {
                        $error = 'An error occurred while creating your account. Please try again.';
                    }
                    }
                }  
            }

        $this->view('create/index', [
            'error' => $error,
            'username' => $username,
            'success' => $success ?? ''
        ]);
    }
}