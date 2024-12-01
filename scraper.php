<?php

function fetchWebPage($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
    }

    curl_close($ch);
    return $response;
}

function scrapeDivByClassName($html, $className)
{
    $dom = new DOMDocument();

    @$dom->loadHTML($html);

    $xpath = new DOMXPath($dom);

    $query = "//span[contains(@class, '$className')]";
    $nodes = $xpath->query($query);

    $results = [];

    foreach ($nodes as $node) {
        $results[] = $node->nodeValue;
    }

    return $results;
}
