<?php

class Reports extends Controller {

    public function __construct() {

        // echo 'Username: ' . ($_SESSION['username'] ?? 'not set'); exit;
        // If user is not logged in, redirect to login page
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
            header('Location: /login');
            exit;
        }

        // If user is not admin, redirect to home page
        if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
            header('Location: /home');
            exit;
        }
    }

    public function index() {
        $this->view('reports/index');
    }

    public function view_all_reminders() {
        $reminder = $this->model('Reminder');
        $all_reminders = $reminder->get_all_reminders_with_users();
        $this->view('reports/view_all_reminders', ['reminders' => $all_reminders]);
    }

    public function most_reminders() {
        $reminder = $this->model('Reminder');
        $most_reminders = $reminder->get_most_reminders_by_user();
        $this->view('reports/most_reminders', ['results' => $most_reminders]);
    }

    public function login_counts() {
        $user = $this->model('User');
        $login_counts = $user->get_login_counts();
        $this->view('reports/login_counts', ['results' => $login_counts]);
    }
}