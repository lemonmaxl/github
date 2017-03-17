<?php
namespace Home\Model;
use Think\Model;

class AreaModel extends Model{
    // 获取三级地区信息
    public function getArea(){
        $data = $this -> select();
        //dump($data);
        $_ret = array();
        foreach ($data as $k => $v){
            // 一级地区
            if($v['parent_id'] == 0){
                foreach($data as $k1 => $v1){
                    if($v1['parent_id'] == $v['id']){
                        foreach ($data as $k2 => $v2){
                            if($v2['parent_id'] == $v1['id']){
                                $v1['area'][] = $v2;
                            }
                        }
                        $v['city'][] = $v1;
                    }
                }
                $_ret[]=$v;
            }
        }
        return $_ret;
    }
}