<?php
// 本类由系统自动生成，仅供测试用途
class BaseAction extends Action {
    protected $user;
            
    function __construct()
    {
        $key = $_REQUEST['key'];
        $userMod = D('User');
        $this->user = $userMod->where('user_key="'.$key.'"')->find();
    }
}