<?php

class DataProcessor
{
    /*
     * Processed file and returns array with data
     */
    public function process()
    {
        $json = file_get_contents("./data/apiResponse" .  date('m-d-Y') . '.json', true);
        $jsonArray = json_decode($json, true);
        return $jsonArray["data"]["children"];
    }
}
