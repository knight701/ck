<?php
class UserAction extends BaseAction {
    
    public function login()
    {
        $userName = $_REQUEST['userName'];
        $password = $_REQUEST['password'];

        $userMod = D('User');
        if($key = $userMod->checkLogin($userName, $password))
        {
            die(json_encode(array(
                'result'=>0,
                'msg'=>'登录成功',
                'key'=>$key,
            )));
        }
        die(json_encode(array(
            'result'=>1,
            'msg'=>'登录失败',
        )));
    }
    
    public function userInfo()
    {
        if(!$this->user)
        {
            die(json_encode(array(
                'result' => 2,
            )));
        }
        die(json_encode(array(
            'result'=>0,
            'user'=>$this->user,
        )));
    }
}