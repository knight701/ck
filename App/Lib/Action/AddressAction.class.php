<?php
class AddressAction extends BaseAction {
    
    public function lists()
    {
        if(!$this->user)
        {
            die(json_encode(array(
                'result' => 2,
            )));
        }
        $addressMod = D('Address');
        $addressList = $addressMod->where('user_id='.$this->user['id'])->select();
        die(json_encode(array('result'=>0,'addressList'=>$addressList)));
    }

    public function add()
    {
        if(!$this->user)
        {
            die(json_encode(array(
                'result' => 2,
            )));
        }
        $data['user_id'] = $this->user['id'];
        $data['province'] = $_REQUEST['province'];
        $data['city'] = $_REQUEST['city'];
        $data['area'] = $_REQUEST['area'];
        $data['address'] = $_REQUEST['address'];
        $data['consignee'] = $_REQUEST['consignee'];
        $data['mobile'] = $_REQUEST['mobile'];
        $data['postcode'] = $_REQUEST['postcode'];
        $data['is_default'] = $_REQUEST['isDefault'];
        
        $addressMod = D('Address');
        
        //如果添加的是默认地址
        if($data['is_default'] == 1)
        {
            $otherData['is_default'] = 0;
            $addressMod->where('user_id='.$this->user['id'])->save($otherData);
        }
        else
        {
            //如果添加的是第一个地址，设为默认
            $addressList = $addressMod->where('user_id='.$this->user['id'])->select();
            if(!$addressList)
            {
                $data['is_default'] = 1;
            }
        }
        if($addressMod->create($data))
        {
            $addressMod->add();
            die(json_encode(array(
                'result' => 0,
            )));
        }
        die(json_encode(array(
            'result' => 1,
        )));
    }
    
    public function edit()
    {
        if(!$this->user)
        {
            die(json_encode(array(
                'result' => 2,
            )));
        }
        $data['province'] = $_REQUEST['province'];
        $data['city'] = $_REQUEST['city'];
        $data['area'] = $_REQUEST['area'];
        $data['address'] = $_REQUEST['address'];
        $data['consignee'] = $_REQUEST['consignee'];
        $data['mobile'] = $_REQUEST['mobile'];
        $data['postcode'] = $_REQUEST['postcode'];
        $data['is_default'] = $_REQUEST['isDefault'];
        
        $addressMod = D('Address');
        if($data['is_default'] == 1)
        {
            $otherData['is_default'] = 0;
            $addressMod = D('Address');
            $addressMod->where('user_id='.$this->user['id'])->save($otherData);
        }
        $addressMod->where('id='.$_REQUEST['id'].' and user_id='.$this->user['id'])->save($data);
        die(json_encode(array(
            'result' => 0,
        )));
    }
    
    public function delete()
    {
        if(!$this->user)
        {
            die(json_encode(array(
                'result' => 2,
            )));
        }
        $id = $_REQUEST['id'];
        $addressMod = D('Address');
        $address = $addressMod->where('id='.$id.' and user_id='.$this->user['id'])->find();
        if($address['is_default'] == 1)
        {
            die(json_encode(array(
                'result' => 3,
                'msg' => '不能删除默认地址'
            )));
        }
        if($addressMod->where('id='.$id.' and user_id='.$this->user['id'])->delete())
        {
            die(json_encode(array(
                'result' => 0,
                'msg' => '删除成功'
            )));
        }
        die(json_encode(array(
            'result' => 1,
            'msg' => '删除失败'
        )));
    }

    public function setDefault()
    {
        if(!$this->user)
        {
            die(json_encode(array(
                'result' => 2,
            )));
        }
        $otherData['is_default'] = 0;
        
        $data['is_default'] = 1;
        $addressMod = D('Address');
        $addressMod->where('user_id='.$this->user['id'])->save($otherData);
        if($addressMod->where('id='.$_REQUEST['id'].' and user_id='.$this->user['id'])->save($data))
        {
            die(json_encode(array(
                'result' => 0,
            )));
        }
        die(json_encode(array(
            'result' => 1,
        )));
    }
}