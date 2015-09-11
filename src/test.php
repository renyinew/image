<?php
namespace renyinew;

require 'Image.php';
require 'Storage.php';


class test extends   Storage{

}

$obj = new test("img");
$_FILES['Filedata']['name'] ="/home/renyi/image/src/123.jpg";
$_FILES['Filedata']['size'] ="123";
$obj->saveFile();
//ObjectId("55efef3b6803fa71108b4568"),