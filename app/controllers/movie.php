<?php 

class Movie extends Controller {

    public function index() {
        $this->view('movie/index');
    }

    public function search() {
        if (!isset($_REQUEST['movie']) || empty($_REQUEST['movie'])) {
            header('Location: /movie');
        }

        $api = $this->model('Api');

        $movie_title = $_REQUEST['movie'];
        $release_date = $_REQUEST['release_date'];
        $movie = $api->search_movie($movie_title, $release_date);

        // if movie is not found or API call fails, display error message
        if (!$movie || !isset($movie['Response']) || $movie['Response'] === 'False') {
            if (isset($movie['Error'])) {
                $error_message = 'Movie not found. Please try again.';
                $this->view('movie/index', ['error' => $error_message]);
                return;
            }
            
        // if movie is found, display movie details on same page
        $this->view('movie/index', ['movie' => $movie]);
    }

        // COSC PRoject
        // Movie [search....]
        // [Search Button]
        // Under Search button: [Movie Title] [Release Date]
        // Movie Rating: 1 (a href=/movie/review/movietitle/1), 2, 3, 4, 5 -> [Submit Button]
        // Use bootstrap for submit button (5 stars)
            // getbootstrap.com > star icons
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

        // Create a session variable to store the success message
        $_SESSION['success_message'] = $success_message;
        header('Location: /movie/search?movie=' . urlencode($movie_title) . '&release_date=' . urlencode($movie_year));
        exit;
    }
}