<?php

require_once("./classes/ApiCall.php");
require_once("./classes/DataProcessor.php");
require_once("./classes/Renderer.php");
$apiCaller = new ApiCall();
$url = "https://www.reddit.com/.json?limit=99999";
//call api once to make sure we have at least some data
$apiCaller->call($url);


$dataProcessor = new DataProcessor();
$data = $dataProcessor->process();
$renderer = new Renderer();
$renderer->renderHead();
$renderer->renderFilter();
$renderer->renderFeeds($data);
$renderer->renderClientScript($data);
$renderer->renderFooter();

//call api again every 10 minutes for fresh data and refresh the page
while (true) {
    sleep(3600);
    $apiCaller->call($url);
    header("refresh: 10");
}
