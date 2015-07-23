<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header("Content-type:text/html;charset=utf-8");
$url=$_SERVER['REQUEST_URI'];
$arr=explode('/',$url);
$command=end($arr);
$data=file_get_contents('php://input', 'r');
if($command=='getsort') {
    include 'remoteGetSort.php';
    $handle = new remoteGetSort();
    echo $handle->getSort($data);

}else{
   exit;
}





