<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/29
 * Time: 16:43
 */
require __DIR__ . '/../../bootstrap.php';

$str = <<<XML
<p237:getNewSampleSerialNumsOutput xmlns:p237="http://www.cat.com/sos/2008/07/15/EquipmentService/"><Equipment><p463:serialNumber xmlns:p463="http://www.cat.com/dds/Equipment/2008/07/15">ZBD11674</p463:serialNumber><p463:make xsi:nil="true" xmlns:p463="http://www.cat.com/dds/Equipment/2008/07/15"/></Equipment><Equipment><p463:serialNumber xmlns:p463="http://www.cat.com/dds/Equipment/2008/07/15">ZBF11179</p463:serialNumber><p463:make xsi:nil="true" xmlns:p463="http://www.cat.com/dds/Equipment/2008/07/15"/></Equipment></p237:getNewSampleSerialNumsOutput>
XML;

$pattern = '/<Equipment>.*?<\/Equipment>/';

preg_match_all($pattern, $str, $match);

dump($match);