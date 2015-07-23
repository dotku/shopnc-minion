<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logremote
 *
 * @author Administrator
 */
class remoteLog {
    
    public  $dir;
    
    public  $path;
    
    public  $filename;
   
    
    
    public function __construct() {
        $this->path=dirname(__FILE__);
        $this->dir=$this->path.'/log/';

    }

    public function logInput($msg,$explain=''){

        $this->filename = 'log-input-';
        return $this->logsend($msg,$explain);
    }

    public function logOutput($msg,$explain=''){
        $this->filename = 'log-output-';
        return $this->logsend($msg,$explain);
    }
    
    public function logsend($msg,$explain=''){

        date_default_timezone_set('Asia/Shanghai');
        $server_date = date("Y-m-d");
        $file_dir = $this->dir;

        $filename = $this->filename . $server_date . ".txt";
        $path = $file_dir . $filename;
        $time = time();
        $time_str = date("Y-m-d H:i:s", $time);
        $deal_msg='';
        if($explain!=''){
            $deal_msg.=$explain;
        }
        if(is_array($msg)){
            $deal_msg.=' '.var_export($msg,true);
        }else{
            $deal_msg.=' '.$msg;
        }
        $message = '>>>>>' . $time_str . '>>>>>' . $deal_msg . "\r\n";

        if (!file_exists($file_dir)) {
            if (!mkdir($file_dir, 0777)) {
                exit();
            }
        }
        if (!file_exists($path)) {
            fopen($path, "w+");
        }
        if (is_writable($path)) {
            $handle = fopen($path, 'a');
            fwrite($handle, $message);
            fclose($handle);
        } else {
            die('wrong write');
        }
        return true;
           
 }
 
}
