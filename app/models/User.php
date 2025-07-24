<?php

class User {

    public $username;
    public $password;
    public $auth = false;

    public function __construct() {

    }

    public function test () {
      $db = db_connect();
      $statement = $db->prepare("select * from users;");
      $statement->execute();
      $rows = $statement->fetch(PDO::FETCH_ASSOC);
      return $rows;
    }

    public function create_user($username, $password) {
        $db = db_connect();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "
            INSERT INTO users (username, password)
            VALUES (:username, :password)
        ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hash,     PDO::PARAM_STR);
        $stmt->execute();
        return $db->lastInsertId(); // If we need to know the ID of the new user
    }

    public function checkUsername($username)
    {
        $db = db_connect();
        $sql = "
            SELECT id
              FROM users
             WHERE username = :username
             LIMIT 1
        ";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $userAccount = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        // If fetch() returned false or null, that username does not exist
        return ($userAccount === false || $userAccount === null);
    }

    public function authenticate($username, $password)
    {
        $db = db_connect();

        $sql = "
            SELECT *
              FROM users
             WHERE username = :username
             LIMIT 1
        ";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $userAccount = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        // At this point, $useraccount is either empty or has a value
        if ($userAccount !== false && $userAccount !== null) {
            // Compare plaintext $password against the stored hash
            if (password_verify($password, $userAccount['password'])) {
                return $userAccount;
            } else {
                // Wrong password
                return null;
            }
        }    
        // Username not found
        return null;
    }

    public function notEmptyAccount($username, $password) {
        return !empty($username) && !empty($password);
    }

    public function logLoginAttempt($username, $status) {
        $db = db_connect();
        $sql = "
            INSERT INTO login_logs (attempted_username, attempt)
            VALUES (:username, :attempt)
        ";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':attempt', $status, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function get_login_counts() {
        $db = db_connect();
        $sql = "
            SELECT attempted_username as username, COUNT(*) as login_count
            FROM login_logs 
            WHERE attempt = 'good'
            GROUP BY attempted_username
            ORDER BY login_count DESC
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
}