<?php

class Login extends Controller {

	public function index() {
		// Retrieve any login error from session and pass to view
		$error = $_SESSION['loginError'] ?? '';
		unset($_SESSION['loginError']);

		// Lockout check: after 3 failed attempts, lockout for 60 seconds
		$locked = false;
		if (isset($_SESSION['failedAttempts'], $_SESSION['firstFailTime']) && $_SESSION['failedAttempts'] >= 3) {
			$currentTime = time();
			$timeDiff = $currentTime - $_SESSION['firstFailTime'];
			if ($timeDiff < 60) {
				$locked = true;
			} else {
				unset($_SESSION['failedAttempts'], $_SESSION['firstFailTime']);
			}
		}

		$this->view('login/index', [
			'error'  => $error,
			'locked' => $locked
		]);
	}

	public function verify() {
		$username = trim($_POST['username'] ?? '');
		$password = trim($_POST['password'] ?? '');
		$userObj = $this->model('User');

		// Lockout check: after 3 failed attempts, lockout for 60 seconds
		if (isset($_SESSION['failedAttempts'], $_SESSION['firstFailTime']) && $_SESSION['failedAttempts'] >= 3) {
			$currentTime = time();
			$timeDiff = $currentTime - $_SESSION['firstFailTime'];
			if ($timeDiff < 60) {
				// Lockout period is not over yet
				$_SESSION['loginError'] = 'Too many attempts. Please wait 60 seconds before trying again.';
				header('Location: /login');
				exit;
			} else {
				// Lockout period is over, reset failed attempts
				unset($_SESSION['failedAttempts'], $_SESSION['firstFailTime']);
			}
		}

		// Treat it as failed login attempt if either field is empty
		if ($userObj->notEmptyAccount($username, $password) == false) {
			// Log bad attempt
			$userObj->logLoginAttempt($username, 'bad');

			if (isset($_SESSION['failedAttempts'])) {
				$_SESSION['failedAttempts']++;
			} else {
				// First attempt
				$_SESSION['failedAttempts'] = 1;
				$_SESSION['firstFailTime'] = time();
			}
			if ($_SESSION['failedAttempts'] >= 3) {
				$_SESSION['loginError'] = 'Too many attempts. Please wait 60 seconds before trying again.';
			} else {
				$_SESSION['loginError'] = 'Username and password cannot be empty.';
			}
			header('Location: /login');
			exit;
		}

		// Verify username and password
		$user = $userObj->authenticate($username, $password);

		if ($user !== null) {
			// Log successful attempt
			$userObj->logLoginAttempt($username, 'good');

			// Login successful, perform the following steps:
			$_SESSION['auth'] = true;
			$_SESSION['username'] = $user['username'];
			$_SESSION['user_id'] = $user['id'];

			if (isset($_SESSION['loginSuccess'])) {
				$_SESSION['loginSuccess']++;
			} else {
				$_SESSION['loginSuccess'] = 1;
			}
			// Reset failed attempts
			unset($_SESSION['failedAttempts'], $_SESSION['firstFailTime']);
			header('Location: /home');
			exit;
		} else {
			// Login failed, track failed attempts
			// Log bad attempt
			$userObj->logLoginAttempt($username, 'bad');
			if (isset($_SESSION['failedAttempts'])) {
				$_SESSION['failedAttempts']++;
			} else {
				$_SESSION['failedAttempts'] = 1;
				$_SESSION['firstFailTime'] = time();
			}
			if ($_SESSION['failedAttempts'] >= 3) {
				$_SESSION['loginError'] = 'Too many attempts. Please wait 60 seconds before trying again.';
			} else {
				$_SESSION['loginError'] = 'Invalid credentials.';
			}
			header('Location: /login');
			exit;
		}
	}
}