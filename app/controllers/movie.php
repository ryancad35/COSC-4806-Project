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

        // Check for existing rating (use normal title, not encoded)
        $rating_model = $this->model('Rating');
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $existing_rating = $rating_model->get_user_rating($movie_title, $movie['Year'], $user_id);
        $user_score = $existing_rating ? $existing_rating['rating'] : 0;

        // if movie is found, display movie details on same page
        $this->view('movie/index', [
            'movie' => $movie,
            'user_score' => $user_score
        ]);
    }

    public function review($movie_title = '', $movie_year = '', $rating = '') {
        // if rating isn't 1-5, redirect to movie page
        if (!in_array($rating, ['1', '2', '3', '4', '5'])) {
            header('Location: /movie');
            exit;
        }

        // Decode the URL-encoded movie title
        $decoded_movie_title = urldecode($movie_title);
        $decoded_movie_year = urldecode($movie_year);

        // Tie movie controller to rating model
        $rating_model = $this->model('Rating');

        // Check if user is logged in
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        // Check if user has already rated this movie (use decoded title)
        $existing_rating = $rating_model->get_user_rating($decoded_movie_title, $decoded_movie_year, $user_id);
        if ($existing_rating) {
            $_SESSION['error_message'] = 'You have already rated this movie.';
            header('Location: /movie/search?movie=' . urlencode($decoded_movie_title) . '&release_date=' . urlencode($decoded_movie_year));
            exit;
        }

        // Add rating to our database (use decoded title)
        $rating_model->add_rating($decoded_movie_title, $decoded_movie_year, $rating, $user_id);
        $success_message = 'Rating submitted successfully!';

        // Store success message in session
        $_SESSION['success_message'] = $success_message;

        // Redirect back to the search results page to stay on same movie
        header('Location: /movie/search?movie=' . urlencode($decoded_movie_title) . '&release_date=' . urlencode($decoded_movie_year));
        exit;
    }

    public function ai_review($movie_title = '', $movie_year = '', $rating = '') {
        // if rating isn't 2-5, redirect to movie page
        if (!in_array($rating, ['2', '3', '4', '5'])) {
            header('Location: /movie');
            exit;
        }

        // Get movie data first 
        $api = $this->model('Api');
        $decoded_movie_title = urldecode($movie_title);
        $movie = $api->search_movie($decoded_movie_title, $movie_year);

        // Get AI review
        $review = $api->generateReview($decoded_movie_title, $movie_year, $rating);

        if ($movie && $review) {
            // Check if user has existing rating for this movie
            $rating_model = $this->model('Rating');
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            $existing_rating = $rating_model->get_user_rating($decoded_movie_title, $movie_year, $user_id);
            $user_score = $existing_rating ? $existing_rating['rating'] : 0;
            // Display on same page
            $this->view('movie/index', [
                'movie' => $movie,
                'ai_review' => $review,
                'ai_rating' => $rating,
                'user_score' => $user_score
            ]);
        } else {
            $_SESSION['error_message'] = 'Could not generate review. Please try again.';
            header('Location: /movie');
            exit;
        }
    }
}