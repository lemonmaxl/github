<?php
namespace Home\Model;
use Think\Model;

class AddressModel extends Model{
    // 设置允许接受的字段
    protected $insertFields = 'member_id,shr_name,province,city,area,zip,addr,mobile,phone,is_default';
    // 设置验证规则
    protected $_validate = array(
        array('province','require','收货人所在省份不能为空!',1),
        array('city','require','收货人所在城市不能为空!',1),
        array('area','require','收货人所在县区不能为空!',1),
        array('shr_name','require','收货人姓名不能为空!',1),
        array('addr','require','详细地址不能为空!',1),
        array('mobile','require','手机号码必须填写!',1),
        array('zip','require','邮编不能为空!',1),
    );
    // 获取所有的地址
    public function getAddrLst(){
        $memberId = session('id');
        if (!$memberId) {
            $this->error = '请先登录!';
            return false;
        }

        return $data = $this->where(array(
                'member_id' => $memberId,
            ))->select();

    }

}