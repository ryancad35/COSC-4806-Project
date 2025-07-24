<?php 

class Movie extends Controller {

    public function index() {
        $this->view('movie/index');
    }

    public function search() {
        if (!isset($_REQUEST['movie'])) {
            // redirect to /movie
        }

        $api = $this->model('Api');

        $movie_title = $_REQUEST['movie'];
        $release_date = $_REQUEST['release_date'];
        $movie = $api->search_movie($movie_title, $release_date);

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