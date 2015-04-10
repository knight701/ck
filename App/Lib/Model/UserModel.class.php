<?php

class UserModel extends RelationModel {
    protected $tableName = 'user';
    
    public function checkLogin($userName, $password)
    {
        import('@.Util.Rsa');
        $rsa = new Rsa();
        //echo $rsa->privDecrypt($password);exit;
        $password = md5($rsa->privDecrypt($password));
        
        $user = $this->where('user_name="'.$userName.'"')->find();
        
        if($user && $user['password']==$password)
        {
            if(!$user['user_key'])
            {
                $data['id'] = $user['id'];
                $data['user_key'] = md5(time().'-'.$user['id']);
                $this->save($data);
                return $data['user_key'];
            }
            return $user['user_key'];
        }
        return false;
    }
    
    public function checkUser($key)
    {
        $user = $this->where('user_key="'.$key.'"')->find();
        if($user)
        {
            return TRUE;
        }
        return FALSE;
    }
}

?>