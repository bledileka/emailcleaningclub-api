<?php
namespace EmailcleaningclubApi\Verification;

class Apicall {
    /**
     * @var string
     */
    private $api_key;
    /**
     * @var string
     */
    private $apiURL;

    public function __construct($api_key)
    {

        if (isset($api_key) && $api_key != "") {
            $this->api_key = trim(strip_tags($api_key));
        } else {
            /* no api key ?*/
            die('Please provide an api key!');
        }
        $this->apiURL = "https://api.emailcleaning.club/api/v1/";
    }

    public function _call($options)
    {
        if (isset($options) && is_array($options)) {
            $str = "";
            foreach ($options as $name => $value) {
                $str .= '&' . $name . "=" . $this->url_encode($value);
            }
            $url = $this->apiURL . "?api_key=" . $this->api_key . $str;
        } else {
            die("Parameters missing ?");
        }

        $ch = curl_init();
        $ua = "PHP Curl Request";
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $ua = $_SERVER["HTTP_USER_AGENT"];
        }

        $headers = array('Content-Type: application/json',
            'X-Api-Key: ' . $this->api_key,
            "User-Agent: " . $ua,
        );

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        );

        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);

        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            die("FATAL --> cURL error: ($errno): $error_message");
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 0) {
            die("cURL call failed. Please make sure the API endpoint url is reachable!");
        } else {
            return json_decode($result, true);
        }
    }

    function url_encode($string)
    {
        /*
         * Simple function to format/encode some particular cases
         */
        if (!is_array($string)) {
            $str = urlencode($string);
            $str = str_replace("%28", "(", $str);
            $str = str_replace("%29", ")", $str);
            $str = str_replace("%3D", "=", $str);
            $str = str_replace("%2C", ",", $str);
            $str = str_replace("%21", "!", $str);
            return str_replace("+", "%20", $str);
        } else {
            $return = "";
            if (isset($string[0])) {
                foreach ($string[0] as $a => $str) {
                    $str = urlencode($str);
                    $str = str_replace("%28", "(", $str);
                    $str = str_replace("%29", ")", $str);
                    $str = str_replace("%3D", "=", $str);
                    $str = str_replace("%2C", ",", $str);
                    $str = str_replace("%21", "!", $str);
                    $str = str_replace("+", "%20", $str);
                    $return .= '&' . $a . "=" . $str;
                }
            }
            return $return;
        }
    }
}