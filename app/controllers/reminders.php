<?php

class Reminders extends Controller {

    public function __construct() {
        // If user is not logged in, redirect to login page
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
            header('Location: /login');
            exit;
        }
    }
    // Display all reminders
    public function index() {
        $reminder = $this->model('Reminder');
        $list_of_reminders = $reminder->get_all_reminders_with_users();
        $remindersList = $reminder->create_reminders_list($list_of_reminders);
        $this->view('reminders/index', ['reminders' => $list_of_reminders, 'remindersList' => $remindersList]);
    }

    // Redirect to page to create a new reminder when user clicks on the link
    public function create() {
        $reminder = $this->model('Reminder');
        $this->view('reminders/create');
    }

    // Capture when user submits a new reminder by clicking on the submit button
    public function create_reminder() {
        $action = filter_input(INPUT_POST, 'action');

        if ($action === 'Submit Reminder') {
            $message = trim(filter_input(INPUT_POST, 'message'));

            if (!empty($message)) {
                $reminder = $this->model('Reminder');
                $reminder->add_reminder($message);

                // Set toast message
                $_SESSION['toast_title'] = 'Success!';
                $_SESSION['toast_message'] = 'Reminder created successfully!';
                $_SESSION['toast_type'] = 'success';

                header('Location: /reminders');
                exit;
            } else {
                $error = 'Reminder message cannot be empty.';
                $this->view('reminders/create', ['error' => $error]);
                return $error;
            }
        }
    }

    public function edit_reminder() {
        $action = filter_input(INPUT_POST, 'action');

        if ($action === 'Edit Reminder') {
            $message = trim(filter_input(INPUT_POST, 'message'));
            $id = filter_input(INPUT_POST, 'id'); 

            if (!empty($message)) {
                $reminder = $this->model('Reminder');
                $reminder->edit_reminder($message, $id);

                // Set toast message
                $_SESSION['toast_title'] = 'Success!';
                $_SESSION['toast_message'] = 'Reminder updated successfully!';
                $_SESSION['toast_type'] = 'success';

                header('Location: /reminders');
                exit;
            } else {
                $error = 'Reminder message cannot be empty.';
                $reminder = $this->model('Reminder');
                $reminderData = $reminder->get_reminder_by_id($id);
                $this->view('reminders/edit', [
                    'error' => $error, 
                    'id' => $id, 
                    'reminder' => $reminderData
                ]);
            }
        }
    }

    public function edit($id) {
        $reminder = $this->model('Reminder');

        // Get the reminder by ID
        $reminderData = $reminder->get_reminder_by_id($id);

        // Pass ID and reminder data to the view
        $this->view('reminders/edit', [
                    'id' => $id,
                    'reminder' => $reminderData
                    ]);     
    }

    // Delete a reminder
    public function delete($id) {
        $reminder = $this->model('Reminder');
        $reminder->delete_reminder($id);

        // Set toast message
        $_SESSION['toast_title'] = 'Deleted!';
        $_SESSION['toast_message'] = 'Reminder deleted successfully!';
        $_SESSION['toast_type'] = 'success';

        header('Location: /reminders');
        exit;
    }


}