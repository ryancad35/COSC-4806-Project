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
        }

        // COSC PRoject
        // Movie [search....]
        // [Search Button]
        // Under Search button: [Movie Title] [Release Date]
        // Movie Rating: 1 (a href=/movie/review/movietitle/1), 2, 3, 4, 5 -> [Submit Button]
        // Use bootstrap for submit button (5 stars)
            // getbootstrap.com > star icons
        

        $this->view('movie/results', ['movie' => $movie]);
    }

    public function review($movie_title = '', $release_date = '', $rating = '') {
        // if rating isn't 1,2,3,4,5 etc.
    }
}