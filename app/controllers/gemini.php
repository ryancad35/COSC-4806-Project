<?php 

class Gemini extends Controller {

    public function index() {
        // This is a test function to see if the gemini API is working
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
        $result = json_decode($response, true);
        echo "<pre>";
        print_r($result);
        die;
    }     
}
?>