<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of remoteregister
 *
 * @author Administrator
 */
include 'base/remote.php';
class remoteRegister extends remote{
    
    public $remoteUrl='';
    
    public $data='';
    
    public function __construct() {
        parent::__construct();

    }
    
    public function register($data){
        $this->data=$data;
        return true;
    }
    //put your code here
}
