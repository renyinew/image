<?php
/**
 * Created by PhpStorm.
 * User: renyinew
 * Date: 2015/9/9
 * Time: 15:16
 */
namespace renyinew;

use Exception;
abstract class Render {
    protected  $type;

    protected $isWaterMark = true;
    protected $waterCC = true;
    protected $waterRB = true;

    /**
     * @param $type
     * @return Render
     * @throws Exception
     */
    static function getInstance($type){
        switch($type){
            case 'news' :
                $class = 'BaikeImgRender';
                break;
            case 'logo' :
                $class = 'BrandLogoImgRender';
                break;
            default :
                throw(new Exception("invalid type"));
        }

        return new $class($type);
    }

    function __construct($type){
        $this->type = $type;
    }

    function render($id, $size = null){
        if(!$id){
            throw(new Exception("invalid id"));
        }
        $gfs = $this->getGfs();
        $image = $gfs->get(new MongoId($id));
        if(!$image){
            throw(new Exception('Image not found'));
        }

        if($size && $size != 'sn'){
            // 小图尺寸
            $sizes = $this->getSize($size);
            if(!$sizes){
                throw(new Exception("invalid size"));
            }

            // 生成小图
            $content = makeThumbBytes($image->getBytes(), $sizes['w'], $sizes['h'], $sizes['m']);
        }else{
            $content = $image->getBytes();
        }

        // 存图片
        $file = $this->fileCache($content, $id, $size);

        if($this->isWaterMark && $file && $size != 'sn'){
            // 加水印
            //waterMark($file, 'rb');
            if($this->waterCC)
                waterMark($file, 'cc' , 50);
            if($this->waterRB)
                waterMark($file, 'rb' , 100);
        }


        // show image
        showImgByte(file_get_contents($file));
    }

    protected function fileCache($content, $id, $size = ''){
        $file = imgUrl($this->type, $id, $size, false);
        $dir = dirname($file);

        if(!is_dir($dir)){
            std_mkdirr($dir, 0755);
        }

        file_put_contents($file, $content);
        return $file;
    }

    /**
     * @return \MongoGridFS
     */
    abstract protected  function getGfs();
    abstract protected function getSize($size);
}