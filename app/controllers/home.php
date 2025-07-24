<?php

class Home extends Controller {

    // Redirect to login page if user is not logged in
    public function __construct() {
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
            header('Location: /login');
            exit;
        }
    }

    public function index() {
      $user = $this->model('User');
      $data = $user->test();

        $this->view('home/index');
        die;
    }
}