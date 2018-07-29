<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/7/29
 * Time: 20:14
 */

namespace PHP\Modern;

use GuzzleHttp\Client;
use League\Csv\Reader;

require __DIR__ . '/../vendor/autoload.php';

$client = new Client();

$csv = Reader::createFromPath($argv[1]);

foreach ($csv as $item) {
    try {
        $httpRes = $client->get($item[0]);

        if ($httpRes->getStatusCode() >= 400) {
            throw new \Exception();
        }
    } catch (\Exception $e) {
        echo $item[0] . PHP_EOL;
    }
}