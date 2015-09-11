<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/9
 * Time: 15:27
 */

class Save{

    /**
     * @param \MongoGridFS $gfs
     * @return mixed
     */
    public function saveFile($uf = 'Filedata'){
        $this->check($uf);
        $id =  $this->getGfs()->storeUpload($uf);
        if(!$id){
            throw(new Exception("Save file fail", self::ERROR_CODE_SAVE));
        }
        return $id;
    }


}
