<?php
require_once 'scraper.php';

$BASE_URL = 'https://www.tgju.org';
$ENDPOINTS = [
    'gold' => '/profile/geram18',
    'dollar' => '/profile/price_dollar_rl'
];

function getPriceData($baseUrl, $endpoint, $className = 'price')
{
    $htmlContent = fetchWebPage($baseUrl . $endpoint);
    $divContent = mb_convert_encoding(scrapeDivByClassName($htmlContent, $className), 'ISO-8859-1', 'UTF-8');

    if (!empty($divContent)) {
        $rawPrice = str_replace(',', '', substr($divContent[0], 0, -1));
        $formattedPrice = number_format($rawPrice);
        return [
            'formatted' => $formattedPrice,
            'raw_price' => $rawPrice
        ];
    }
    return ['formatted' => '0', 'raw_price' => '0'];
}

$goldData = getPriceData($BASE_URL, $ENDPOINTS['gold']);
$dollarData = getPriceData($BASE_URL, $ENDPOINTS['dollar']);


$array = [
    'price_base' => 'toman',
    '18-karat gold' => $goldData,
    'dollar' => $dollarData
];

echo json_encode($array);
