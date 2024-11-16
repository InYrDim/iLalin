<?php

class RapidAPIClient {
    private $apiKey;
    private $baseUrl;
    private $rapidapihost;

    public function __construct($url, $rapidhost, $apiKey = null) {
        $this->apiKey = $apiKey !== null ? $apiKey : getenv('API_KEY');
        $this->baseUrl = $url;
        $this->rapidapihost = $rapidhost;
    }


    public function get($endpoint, $params = []) {
        $queryString = http_build_query($params);
        $url = "{$this->baseUrl}/{$endpoint}?{$queryString}";
        $headers = [
        "x-rapidapi-key: {$this->apiKey}",
        "x-rapidapi-host: {$this->rapidapihost}",
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
        throw new Exception("HTTP error! Status: {$httpCode}");
        }

        curl_close($ch);

        return $response;
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    //read php input parameters using php://infput
    header('Content-Type: application/json');
    echo '{
    "html_attributions" : [],
    "results" : 
    [
        {
            "business_status" : "OPERATIONAL",
            "formatted_address" : "Pantai Tanjung Bayang, Selat, Tj. Merdeka, Kec. Tamalate, Kota Makassar, Sulawesi Selatan 90225, Indonesia",
            "geometry" : 
            {
                "location" : 
                {
                "lat" : -5.1835531,
                "lng" : 119.3892559
                },
                "viewport" : 
                {
                "northeast" : 
                {
                    "lat" : -5.1724406,
                    "lng" : 119.4052633
                },
                "southwest" : 
                {
                    "lat" : -5.1946654,
                    "lng" : 119.3732485
                }
                }
            },
            "icon" : "https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/geocode-71.png",
            "icon_background_color" : "#7B9EB0",
            "icon_mask_base_uri" : "https://maps.gstatic.com/mapfiles/place_api/icons/v2/generic_pinlet",
            "name" : "Pantai Tanjung Bayang",
            "opening_hours" : 
            {
                "open_now" : true
            },
            "photos" : 
            [
                {
                "height" : 393,
                "html_attributions" : 
                [
                    "\u003ca href=\"https://maps.google.com/maps/contrib/108933192699493680127\"\u003eA Google User\u003c/a\u003e"
                ],
                "photo_reference" : "AdDdOWrYkMtfc8taqRZUkfQNo5nKItNMsPxDDbxvI11tfCQOvoR-RYdEUaz7zpyJchPlbA-VcFIXwDbAuRIjOJrUPYeVM8IyVlvzCxyle20obsCnLDQXQyqjVq9E3pAxXb7SAcVHr20entidU6MunCbEYYo0zbu1mrhi56FzPII1pXYWgopX",
                "width" : 700
                }
            ],
            "place_id" : "ChIJpxOy4aYdvy0R52UkJNsip8M",
            "rating" : 4.1,
            "reference" : "ChIJpxOy4aYdvy0R52UkJNsip8M",
            "types" : 
            [
                "natural_feature",
                "establishment"
            ],
            "user_ratings_total" : 1583
        }
    ],
    "status" : "OK"
}';
    exit;
    $data = json_decode(file_get_contents('php://input'), true);
  

    $__MAPS_API_URL = "https://google-map-places.p.rapidapi.com";
    $__RAPID_API_KEY = "b106634ee0msh33f5f53acc4e8a2p1f47cbjsnc4181518ee21";
    $__RAPID_API_HOST = "google-map-places.p.rapidapi.com";
    //from data add to rapid api
    $rapid = new RapidAPIClient($__MAPS_API_URL, $__RAPID_API_HOST, $__RAPID_API_KEY);

    $params = $data['place'];    

    $maps_data = $rapid->get($params['endpoint'], $params['params']);

    header('Content-Type: application/json');
    echo $maps_data ;    
}