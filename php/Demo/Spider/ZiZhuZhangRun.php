<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/1/15
 * Time: 09:59
 */

require __DIR__ . '/../../bootstrap.php';

use GuzzleHttp\Pool;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;

$spider = new \PHP\Demo\Spider\ZiZhuZhang();

$spider->run();

// 品牌
$brands = [];
// 车系
$series = [];
// 车型
$models = [];

// 配置
$configs = [];

$timeout = 10;
$concurrency = 100;

ini_set("memory_limit", "512M");

$stack = HandlerStack::create();
$stack->push(Middleware::retry(
    function ($retries) {
        return $retries < 3;
    },
    function ($retries) {
        return pow(2, $retries - 1);
    }
));

$client = new Client([
    "debug" => true,
    "timeout" => $timeout,
    "base_uri" => "https://cars.app.autohome.com.cn",
    "headers" => [
        "User-Agent" => "Android\t6.0.1\tautohome\t8.3.0\tAndroid",
    ],
    "handler" => $stack,
]);

// 品牌列表页
$url = "/cars_v8.3.0/cars/brands-pm2.json";

$response = $client->get($url);
$contents = $response->getBody()->getContents();
$contents = json_decode($contents, true);
$contents = $contents["result"]["brandlist"];

foreach ($contents as $values) {
    $initial = $values["letter"];

    foreach ($values["list"] as $v) {
        $brands[$v["id"]] = [
            "id" => $v["id"],
            "name" => $v["name"],
            "initial" => $initial,
        ];
    }
}

$brands = array_values($brands);

###

$requests = function ($brands) {
    foreach ($brands as $v) {
        $id = $v["id"];
        // 品牌介绍页
        $url = "/cars_v8.3.0/cars/getbrandinfo-pm2-b{$id}.json";
        yield new Request("GET", $url);
    }
};

$pool = new Pool($client, $requests($brands), [
    "concurrency" => $concurrency,
    "fulfilled" => function ($response, $index) use (&$brands) {
        $contents = $response->getBody()->getContents();
        $contents = json_decode($contents, true);
        $contents = $contents["result"]["list"];
        $contents = $contents ? $contents[0]["description"] : "暂无";
        $contents = trim(str_replace(["\r\n", ","], ["\n", "，"], $contents));

        $brands[$index]["description"] = $contents;
    },
]);

$pool->promise()->wait();

$requests = function ($brands) {
    foreach ($brands as $v) {
        $id = $v["id"];
        // 车系列表页
        $url = "/cars_v8.3.0/cars/seriesprice-pm2-b{$id}-t16-v8.3.0.json";
        yield new Request("GET", $url);
    }
};

$pool = new Pool($client, $requests($brands), [
    "concurrency" => $concurrency,
    "fulfilled" => function ($response, $index) use (&$series, $brands) {
        $contents = $response->getBody()->getContents();
        $contents = json_decode($contents, true);
        $contents = $contents["result"];

        $brand_id = $brands[$index]["id"];

        foreach (["fctlist", "otherfctlist"] as $field) {
            $values = $contents[$field];

            foreach ($values as $value) {
                $factory = $value["name"];

                foreach ($value["serieslist"] as $v) {
                    list($min, $max) = explode("-", $v["price"]) + [1 => 0];

                    $min_price = $min * 10000;
                    $max_price = $max * 10000;

                    if ($max_price == 0) {
                        $max_price = $min_price;
                    }

                    $series[$v["id"]] = [
                        "id" => $v["id"],
                        "name" => $v["name"],
                        "level" => $v["levelname"],
                        "factory" => $factory,
                        "min_price" => $min_price,
                        "max_price" => $max_price,
                        "brand_id" => $brand_id,
                    ];
                }
            }
        }
    },
]);

$pool->promise()->wait();

$series = array_values($series);

###

$requests = function ($series) {
    foreach ($series as $v) {
        $id = $v["id"];
        // 车型列表页
        $url = "/carinfo_v8.3.0/cars/seriessummary-pm2-s{$id}-t-c110100-v8.3.0.json";
        yield new Request("GET", $url);
    }
};

$pool = new Pool($client, $requests($series), [
    "concurrency" => $concurrency,
    "fulfilled" => function ($response, $index) use (&$models, $series) {
        $contents = $response->getBody()->getContents();
        $contents = json_decode($contents, true);
        $contents = $contents["result"]['enginelist'];

        $series_id = $series[$index]["id"];

        foreach ($contents as $values) {
            if (in_array($values["yearvalue"], [0, 1])) {
                continue;
            }

            foreach ($values["yearspeclist"] as $value) {
                foreach ($value["speclist"] as $v) {
                    if (isset($models[$v["id"]])) {
                        continue;
                    }

                    $price = $v["price"] * 10000;

                    $description = trim($v["description"]);

                    if (!$description) {
                        $description = "暂无";
                    }

                    $models[$v["id"]] = [
                        "id" => $v["id"],
                        "name" => $v["name"],
                        "status" => $v["state"],
                        "price" => $price,
                        "description" => $description,
                        "series_id" => $series_id,
                    ];
                }
            }
        }
    },
]);

$pool->promise()->wait();

$models = array_values($models);

###

$requests = function ($models) {
    foreach ($models as $v) {
        $id = $v["id"];
        // 车型参数页
        $url = "/cfg_v8.3.0/cars/speccompare.ashx?pm=2&type=1&specids={$id}&cityid=110100&site=2&pl=2";
        yield new Request("GET", $url);
    }
};

$pool = new Pool($client, $requests($models), [
    "concurrency" => $concurrency,
    "fulfilled" => function ($response, $index) use (&$models, &$configs) {
        $contents = $response->getBody()->getContents();
        $contents = json_decode($contents, true);
        $contents = $contents["result"];

        $models[$index]["config"] = [];

        foreach (["paramitems", "configitems"] as $key) {
            $values = $contents[$key];

            foreach ($values as $value) {
                $category = $value["itemtype"];

                foreach ($value["items"] as $v) {
                    $id = $v["id"];

                    if ($id < 1) {
                        continue;
                    }

                    $name = $v["name"];
                    $value = $v["modelexcessids"][0]["value"];

                    if ($value != "-") {
                        $models[$index]["config"][$id] = $value;
                    }

                    if (!isset($configs[$category][$id])) {
                        $configs[$category][$id] = [
                            "id" => $id,
                            "name" => $name,
                            "category" => $category,
                        ];
                    }
                }
            }
        }

        $models[$index]["config"] = json_encode(
            $models[$index]["config"], JSON_UNESCAPED_UNICODE
        );
    },
]);

$pool->promise()->wait();

$configs = call_user_func_array("array_merge", $configs);

// todo: 保存数据
