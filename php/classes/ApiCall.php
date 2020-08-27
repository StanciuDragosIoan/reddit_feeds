<?php

class ApiCall
{
    /*
     *calls api and writes data to file
     */
    public function call($url)
    {

        $curl = curl_init();
        $time =  strtotime("-1 day");


        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));


        // echo $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $response = curl_exec($curl);
        $decoded_JSON =  json_decode($response);
        $encoded_JSON = json_encode($decoded_JSON);

        if (!is_dir("./data")) {
            mkdir("./data");
        }
        $fp = fopen('./data/apiResponse'  . date('m-d-Y') . '.json', 'w');


        fwrite($fp, $encoded_JSON);
        fclose($fp);
        curl_close($curl);
    }
}
