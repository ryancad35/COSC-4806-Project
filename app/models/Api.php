<?php

class Api {

    public function __construct() {
    }

    public function search_movie($movie_title, $release_date = '') {
        // Build OMDB API URL
        $query_url = "http://www.omdbapi.com/?apikey=" . $_ENV['OMDB_KEY'] . "&t=" . urlencode($movie_title);

        // Add year parameter if release date is provided
        if (!empty($release_date)) {
            $query_url .= "&y=" . urlencode($release_date);
        }

        // Make API call
        $json = file_get_contents($query_url);

        if ($json === false) {
            return false;
        }

        // Parse JSON response
        $phpObj = json_decode($json);
        $movie = (array) $phpObj;

        return $movie;
    }
}
