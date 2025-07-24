<?php

class Reminder {

    public function __construct() {
      }

    public function add_reminder($subject) {
        $db = db_connect();
      $query = 'INSERT INTO reminders (subject, user_id) VALUES (:subject, :user_id)';
        $statement = $db->prepare($query);
        $statement->bindValue(':subject', $subject);
        $statement->bindValue(':user_id', $_SESSION['user_id']);
        $statement->execute();
    }

    // Needed for editing specific reminders by id
    public function get_reminder_by_id($id) {
        $db = db_connect();
        $query = 'SELECT * FROM reminders WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $reminder = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $reminder;
    }

    public function get_all_reminders() {
      $db = db_connect();
      $statement = $db->prepare("
      select * from reminders
      ORDER BY created_at DESC;");
      $statement->execute();
      $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $rows;
    }

    public function get_all_reminders_with_users() {
      $db = db_connect();
      $statement = $db->prepare("
        SELECT r.*, u.username 
        FROM reminders r 
        JOIN users u ON r.user_id = u.id 
        ORDER BY r.created_at DESC
      ");
      $statement->execute();
      $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $rows;
    }

    public function get_most_reminders_by_user() {
      $db = db_connect();
      $statement = $db->prepare("
        SELECT u.username, COUNT(r.id) as reminder_count 
        FROM users u 
        LEFT JOIN reminders r ON u.id = r.user_id 
        GROUP BY u.id, u.username 
        ORDER BY reminder_count DESC
      ");
      $statement->execute();
      $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $rows;
    }

    public function edit_reminder($subject, $id) {
      $db = db_connect();
      $query = 'UPDATE reminders SET subject= :subject WHERE id = :id';
      $statement = $db->prepare($query);
      $statement->bindValue(':subject', $subject);
      $statement->bindValue(':id', $id);
      $statement->execute();
      $statement->closeCursor();  
    }

  public function delete_reminder($id) {
    $db = db_connect();
    $query = 'DELETE from reminders WHERE id= :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $statement->closeCursor();  
  }

    function create_reminders_list($reminders)
    {
      $remindersList = "";
  
      foreach ($reminders as $row) {
        $subject = htmlspecialchars($row['subject']);
        $created_at = htmlspecialchars($row['created_at']);
        $username = htmlspecialchars($row['username']);
        $id = $row['id'];

        $remindersList .= "<p><strong>User:</strong> $username</p>";
        $remindersList .= "<p><strong>Reminder:</strong> $subject</p>";
        $remindersList .= "<p><b>Created on:</b> $created_at</p>";
        $remindersList .= "<p>
          <a href='reminders/edit/$id'>Edit</a> | 
          <a href='reminders/delete/$id'>Delete</a>
        </p><hr>";
      }
      return $remindersList;
    }
}