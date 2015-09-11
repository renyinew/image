<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/9
 * Time: 15:24
 */

class Size {

    protected $waterCC = false;
    protected  function getGfs(){
        $mongodb = 'home2';
        $gfsname = 'home_jia';
        return getGfs($gfsname, $mongodb);
    }

    protected function getSize($size){
        $this->isWaterMark = false;
        $method = 'crop';
        switch($size){
            case 'small' :
                $width = 200;
                $height = 200;
                break;
            case 'image_albums_315x395' :
                $width = 315;
                $height = 395;
                break;
            case 'image_albums_188x148' :
                $width = 188;
                $height = 148;
                break;
            case 'image_albums_326x318' :
                $width = 326;
                $height = 318;
                break;
            case 'image_albums_210x210' :
                $width = 210;
                $height = 210;
                break;
            case 'image_albums_622x298' :
                $width = 622;
                $height = 298;
                break;
            case 'image_albums_500x600' :
                $this->isWaterMark = true;
                $this->waterRB = false;
                $this->waterCC = true;
                $method = 'fix';
                $width = 600;
                $height = 0;
                break;
            case 'image_albums_68x55' :
                $width = 68;
                $height = 55;
                break;
            case 'image_albums_512x298' :
                $width = 512;
                $height = 298;
                break;
            case 'image_albums_340x190' :
                $width = 512;
                $height = 298;
                break;
            case 'image_albums_190x150' :
                $width = 190;
                $height = 150;
                break;
            case 'image_albums_200x130' :
                $width = 200;
                $height = 130;
                break;
            case 'image_albums_300x240' :
                $width = 300;
                $height = 240;
                break;
            case 'image_albums_98x85' :
                $width = 98;
                $height = 85;
                break;
            case 'size_300' :
                $method = 'fix';
                $width = 280;
                $height = 0;
                break;
            case 'size_100' :
                $method = 'fix';
                $width = 100;
                $height = 100;
                break;
            case 'size_90' :
                $method = 'fix';
                $width = 90;
                $height = 90;
                break;
            default :
                return array();
        }

        return array(
            'w' => $width,
            'h' => $height,
            'm' => $method
        );
    }
}