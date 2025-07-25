<?php 

class Rating {

    public function __construct() {
    }

    public function add_rating($movie_title, $movie_year, $rating, $user_id = null) {
        $db = db_connect();
        $query = 'INSERT INTO ratings (movie_title, movie_year, rating, user_id) VALUES (:movie_title, :movie_year, :rating, :user_id)';
        $statement = $db->prepare($query);
        $statement->bindValue(':movie_title', $movie_title);
        $statement->bindValue(':movie_year', $movie_year);
        $statement->bindValue(':rating', $rating);
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $statement->closeCursor();
    }

    public function get_user_rating($movie_title, $movie_year, $user_id = null) {
        $db = db_connect();

        // Check if user_id is null or not to determine the query
        if ($user_id === null) {
            // For anonymous users, check for NULL user_id
            $query = 'SELECT * FROM ratings WHERE movie_title = :movie_title AND movie_year = :movie_year AND user_id IS NULL';
            $statement = $db->prepare($query);
            $statement->bindValue(':movie_title', $movie_title);
            $statement->bindValue(':movie_year', $movie_year);
        } else {
            // For logged-in users, check for specific user_id
            $query = 'SELECT * FROM ratings WHERE movie_title = :movie_title AND movie_year = :movie_year AND user_id = :user_id';
            $statement = $db->prepare($query);
            $statement->bindValue(':movie_title', $movie_title);
            $statement->bindValue(':movie_year', $movie_year);
            $statement->bindValue(':user_id', $user_id);
        }
        $statement->execute();
        $rating = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $rating;
    }
}