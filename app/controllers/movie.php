<?php 

class Movie extends Controller {

    public function index() {
        $this->view('movie/index');
    }

    public function search() {
        // Handle both POST (form) and GET (redirect after rating) requests
        $movie_title = $_REQUEST['movie'] ?? '';
        $release_date = $_REQUEST['release_date'] ?? '';

        if (empty($movie_title)) {
            header('Location: /movie');
            exit; 
        }

        $api = $this->model('Api');
        $movie = $api->search_movie($movie_title, $release_date);

        // if movie is not found or API call fails, display error message
        if (!$movie || !isset($movie['Response']) || $movie['Response'] === 'False') {
            $error_message = 'Movie not found. Please try again.';
            $this->view('movie/index', ['error' => $error_message]);
            return;
        }

        // if movie is found, display movie details on same page
        $this->view('movie/index', ['movie' => $movie]);
    }

    public function review($movie_title = '', $movie_year = '', $rating = '') {
        // if rating isn't 1-5, redirect to movie page
        if (!in_array($rating, ['1', '2', '3', '4', '5'])) {
            header('Location: /movie');
            exit;
        }

        // Tie movie controller to rating model
        $rating_model = $this->model('Rating');

        // Check if user is logged in
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // user_id gets set to null in our DB if user is not logged in

        // Add rating to our database
        $rating_model->add_rating($movie_title, $movie_year, $rating, $user_id);
        $success_message = 'Rating submitted successfully!';

        // Store success message in session
        $_SESSION['success_message'] = $success_message;

        // Redirect back to the search results page to stay on same movie
        header('Location: /movie/search?movie=' . urlencode(urldecode($movie_title)) . '&release_date=' . urlencode(urldecode($movie_year)));
        exit;
}
}

// Fix: Removed urlencode($movie_title) from the redirect location to prevent double encoding