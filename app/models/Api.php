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

    public function generateReview($movieTitle, $movieYear, $rating) {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $_ENV['GEMINI_KEY'];

        $prompt = "Please write a movie review for '{$movieTitle}' ({$movieYear}) from the perspective of someone who would rate it {$rating} out of 5 stars. Make it sound like a genuine moviegoer's review, around 200-300 words. Include specific things they liked or disliked that justify the {$rating}/5 rating.";

        $data = array(
            "contents" => array(
                array(
                    "role" => "user",
                    "parts" => array(
                        array(
                            "text" => $prompt
                        )
                    )
                )
            )
        );

        $json_data = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $result = json_decode($response, true);
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                return $result['candidates'][0]['content']['parts'][0]['text'];
            }
        }
        return false;
    }
}
