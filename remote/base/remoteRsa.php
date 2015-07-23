<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rsa
 *
 * @author Administrator
 */
class remoteRsa {
    public $pubkey;
    public $prikey;
    
    public function __construct(){
        $path=dirname(__FILE__);

        $pubkey=$path."/ssl/pubkey.key";
        $prikey=$path."/ssl/prikey.key";
        $fp=fopen("$pubkey","r"); //你的私钥文件路径
        $this->pubkey=fread($fp,8192);
        fclose($fp);
        $fp1=fopen("$prikey","r"); //你的公钥文件路径
        $this->prikey=fread($fp1,8192);
        fclose($fp1);

    }
    
    public function encrypt($data){
        $pubres=openssl_pkey_get_public($this->pubkey);
        openssl_public_encrypt($data,$encrypted,$pubres);
        $encrypted = base64_encode($encrypted); 
        return $encrypted;
    }
    
    public function decrypt($data){
        $prires=openssl_pkey_get_private($this->prikey);
        openssl_private_decrypt(base64_decode($data),$decrypted,$prires);
        return $decrypted;
        
    }
}
