<?php

require __DIR__ . '/../../bootstrap.php';

$items =
    [
        1 => [
            'id' => 1,
            'pid' => 0,
            'name' => '安徽省'
        ],
        2 => [
            'id' => 2,
            'pid' => 0,
            'name' => '浙江省'
        ],
        3 => [
            'id' => 3,
            'pid' => 1,
            'name' => '合肥市'
        ],
        4 => [
            'id' => 4,
            'pid' => 3,
            'name' => '长丰县'
        ],
        5 => [
            'id' => 5,
            'pid' => 1,
            'name' => '安庆市'
        ],
    ];

function generateTree($items)
{
    $tree = [];
    foreach ($items as $item) {
        if (isset($items[$item['pid']])) {
            $items[$item['pid']]['children'][] = &$items[$item['id']];
        } else {
            $tree[] = &$items[$item['id']];
        }
    }
    return $tree;
}

//function generateTree($items)
//{
//    foreach ($items as $item) {
//        $items[$item['pid']]['children'][$item['id']] = &$items[$item['id']];
//    }
//    return isset($items[0]['children']) ? $items[0]['children'] : [];
//}

dump(generateTree($items));

$tree = generateTree($items);
function getTreeData($tree)
{
    foreach ($tree as $t) {
        dump($t['name']);
        if (isset($t['children'])) {
            getTreeData($t['children']);
        }
    }
}

getTreeData($tree);
