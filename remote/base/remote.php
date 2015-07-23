<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of remote
 *
 * @author Administrator
 */

include 'remoteLog.php';
include 'remoteCurl.php';
include 'remoteDb.php';
include 'remoteDes.php';
class remote {

    public $rsa;

    public $log;
    
    public $curl;

    public $db;

    public $des;

    public $mdkey;

    public $deskey;
    
    public function __construct()
    {
        $config=include("config.php");
        $this->mdkey  =$config['mdkey'];
        $this->deskey =$config['deskey'];
        $this->log  =new remoteLog();
        $this->curl =new remoteCurl();
        $this->db   =new remoteDb();
        $this->des  =DES::share();

    }

    public function checkReques(){
        if(count($this->allowIp())>0){
            $allowIp=$this->allowIp();
            $realIp=$this->realIp();
            if($allowIp != $realIp){
                exit('{"msg":"ip are not allow"}');
            }
        }
    }


    public function allowIp(){
        return array();
    }

    public function realIp(){
        static $realip = NULL;
        if ($realip !== NULL){
            return $realip;
        }

        if (isset($_SERVER)){
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($arr AS $ip){
                    $ip = trim($ip);
                    if ($ip != 'unknown'){
                        $realip = $ip;
                        break;
                    }
                }
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])){
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            }else{
                if (isset($_SERVER['REMOTE_ADDR'])){
                    $realip = $_SERVER['REMOTE_ADDR'];
                }else{
                    $realip = '0.0.0.0';
                }
            }
        }else{
            if (getenv('HTTP_X_FORWARDED_FOR')){
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            }elseif (getenv('HTTP_CLIENT_IP')){
                $realip = getenv('HTTP_CLIENT_IP');
            }else{
                $realip = getenv('REMOTE_ADDR');
            }
        }

        preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
        $realip = !emptyempty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

        return $realip;
    }


    public function md5Data($string){
        return md5($string);


    }



    public function var_urlencode($var) {
        if (empty ( $var )) {
            return false;
        }
        if(is_array ($var)){
            foreach ($var as $k => $v ) {
                if (is_scalar ($v)) {
                    $var [$k] = urlencode ($v );
                } else {
                    $var [$k] = $this->var_urlencode ( $v );
                }
            }
        }else {
            $var = urlencode ( $var );
        }
        return $var;
    }

    public function var_json_encode($var) {
        $_var = $this->var_urlencode($var);
        return json_encode($_var);

    }

    public function desSign($data){
        return $this->des->encode($data,$this->deskey);
    }

}
