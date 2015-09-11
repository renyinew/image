<?php
/**
 * Created by PhpStorm.
 * User: renyinew
 * Date: 2015/9/9
 * Time: 15:43
 */
namespace renyinew;
use MongoClient;
use Exception;

abstract class Storage
{
    const TYPE_IMG = 'img'; //���ݱ���

    const MONGO = 'renyi'; //���ݿ���

    const ERROR_CODE_SAVE = 511;
    const ERROR_CODE_TYPE = 512;
    const ERROR_CODE_HASH = 513;

    private $type;

    public $dbs;

    function __construct($type){
        $this->type = $type;
    }

    function getGfs($prefix = 'mongodb', $db = MDB_IMG) {
        if(!isset($this->dbs[$db])){
            $m = new MongoClient();
            $this->dbs[$db] = $m->selectDB($db);
        }
        return $this->dbs[$db]->getGridFS($prefix);
    }

    private function getDB(){
        switch($this->type){
            case self::TYPE_IMG:
                $gfs = $this->getGfs(self::TYPE_IMG, self::MONGO);
                break;
            default :
                throw(new Exception("Invalid upload type", self::ERROR_CODE_TYPE));
        }
        return $gfs;
    }



    private function check($uf){
        if(!isset($_FILES[$uf]) || !$_FILES[$uf])
            throw(new Exception("��ѡ���ϴ��ļ�"));
        $file = $_FILES[$uf];

        // �����չ��
        $tmpName = $file["name"];
        $aliasName = substr($tmpName, 0, strrpos($tmpName, '.'));
        $fileExt = substr($tmpName, strrpos($tmpName, '.') + 1);
        $fileExt = strtolower($fileExt);
        $exts = array('jpg','gif','png','jpeg');
        if(!in_array(strtolower($fileExt), $exts, 1)){
            throw(new Exception("��չ������"));
        }

        //����С
        if($file['size'] > 1024 * 1024){
            throw(new Exception("�ļ�����"));
        }
    }

    /**
     * @param \MongoGridFS $gfs
     * @return mixed
     */
    public function saveFile($uf = 'Filedata'){
        $this->check($uf);
       // $id =  $this->getDB()->storeUpload($uf);
        $id =  $this->getDB()->storeBytes($uf);
        if(!$id){
            throw(new Exception("Save file fail", self::ERROR_CODE_SAVE));
        }
        return $id;
    }

}
