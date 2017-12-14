<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/12/4
 * Time: 10:04
 */

namespace PHP\Ext\Exif;

class ExtExif
{
    public function __construct()
    {
        echo "-------------------------------  ExtExif  ---------------------------------\n";
        $this->read();
        echo "-------------------------------  ExtExif  ---------------------------------\n";
    }

    //JPEG,TIFF
    public function read()
    {
        $exif = exif_read_data(__DIR__.'/P71005-185741.jpg',0,true);

        dump($exif);
    }

}
