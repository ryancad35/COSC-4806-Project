<?php 

class Gemini extends Controller {

    public function index() {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $_ENV['GEMINI_KEY'];

        $data = array(
            "contents" => array(
                array(
                    "role" => "user",
                    "parts" => array(
                        array(
                            "text" => "Please give a review of Barbie from someone that has an average of 4 out of 5."
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
        curl_close($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo "Curl error: " . curl_error($ch);
        }

        // Print the response
        echo "<pre>";
        echo $response;
        die;
    }     

    public function generateReview($movieTitle, $movieYear, $rating) {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $_ENV['GEMINI_KEY'];

        // Create dynamic prompt based on movie and rating the user submitted
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

            // Extract the review text from the response
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                return $result['candidates'][0]['content']['parts'][0]['text'];
            } else {
                return "Sorry, I couldn't generate a review at this time.";
            }
        } else {
            return "Error generating review. Please try again later.";
        }
    }
}
?>