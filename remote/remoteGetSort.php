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
include 'base/remote.php';

class remoteGetSort extends remote{
    


    public function __construct() {
        parent::__construct();

    }

    public function allowIp(){
        return array();
    }

    public function getSort(){
        $this->checkReques();

        $returnStr='para=';
        $sortdata=$this->var_json_encode($this->getSortList());
        $md_result=$this->md5Data($sortdata);
        //$md_result='%A9%E5%85cs#@123ertV[]\"';
        $des='&sign='.$this->desSign($md_result);
        return $returnStr.$sortdata.$des;
    }

    public function getSortList(){
        $sort_array=array();
        $sort_result=$this->db->query("select gc_id,gc_name,gc_parent_id from usc_goods_class order by gc_parent_id,gc_sort asc");
        return $this->getDataTree($sort_result);


    }


    public function getDataTree($rows, $id='gc_id',$pid = 'gc_parent_id',$child = 'chile',$root=0)
    {   $tree = array();
        if(is_array($rows)){
            $array = array();
            foreach ($rows as $key=>$item){
                $array[$item[$id]] =& $rows[$key];
            }
            foreach($rows as $key=>$item){
                $parentId = $item[$pid];
                if($root == $parentId){
                    $tree[] =&$rows[$key];
                }else{
                    if(isset($array[$parentId])){
                        $parent =&$array[$parentId];
                        $parent[$child][]=&$rows[$key];
                    }
                }
            }
        }
        return $tree;
    }



 
}
