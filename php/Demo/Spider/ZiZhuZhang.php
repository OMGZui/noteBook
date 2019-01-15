<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/1/15
 * Time: 09:55
 */

namespace PHP\Demo\Spider;


use GuzzleHttp\Client;
use GuzzleHttp\Pool;

class ZiZhuZhang
{
    public $client;
    private $totalPageCount;
    private $counter = 1;
    private $concurrency = 7;
    private $users = ['CycloneAxe', 'appleboy', 'Aufree', 'lifesign', 'overtrue', 'zhengjinghua', 'OMGZui'];

    public function run()
    {
        $this->totalPageCount = count($this->users);
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->users as $user) {
                $uri = 'https://api.github.com/users/' . $user;
                yield function () use ($client, $uri) {
                    return $client->getAsync($uri);
                };
            }
        };

        $pool = new Pool($client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled' => function ($response, $index) {
                $res = json_decode($response->getBody()->getContents());
                dump("请求第 $index 个请求，用户 " . $this->users[$index] . " 的 Github ID 为：" . $res->id);
                $this->countedAndCheckEnded();
            },
            'rejected' => function ($reason, $index) {
                dump("rejected");
                dump("rejected reason: " . $reason);
                $this->countedAndCheckEnded();
            },
        ]);

        // 开始发送请求
        $promise = $pool->promise();
        $promise->wait();
    }

    public function countedAndCheckEnded()
    {
        if ($this->counter < $this->totalPageCount) {
            $this->counter++;
            return;
        }
        dd("请求结束！");
    }
}