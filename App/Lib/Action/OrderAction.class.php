<?php
class OrderAction extends BaseAction {
    
    public function add()
    {
        if(!$this->user)
        {
            die(json_encode(array(
                'result' => 2,
            )));
        }
        $goods = json_decode($_REQUEST['goods'], TRUE);
        $order['address_id'] = $_REQUEST['addressId'];
        $order['shipping_fee'] = $_REQUEST['shippingFee'];
        $order['discount'] = $_REQUEST['discount'];
        $order['message'] = $_REQUEST['message'];
        $order['user_id'] = $this->user['id'];
        $order['goods_id'] = $goods['goodsId'];
        $order['goods_num'] = $goods['goodsNum'];
        
        $orderMod = D('Order');
        $result = $orderMod->addOrder($order);
        if($result)
        {
            die(json_encode(array(
                'result' => 0,
            )));
        }
        die(json_encode(array(
            'result' => 1,
        )));
    }
    
    public function lists()
    {
        if(!$this->user)
        {
            die(json_encode(array(
                'result' => 2,
            )));
        }
        //需要传分页参数p
        import('ORG.Util.Page'); // 导入分页类
        $status = $_REQUEST['status'];
        $pageSize = $_REQUEST['pageSize'];
        $where = 'user_id='.$this->user['id'];
        if($status)
        {
            $where .= "status=".$status;
        }
        $orderMod = D('Order');
        $count = $orderMod->where($where)->count();
        $page = new Page($count, $pageSize);
        $list = $orderMod->where($where)->order('add_time desc')->limit($page->firstRow . ',' . $page->listRows)->select();
        foreach($list as $k=>$v)
        {
            $list[$k]['goods_img'] = IMG_URL.$v['goods_img'];
        }
        //$show = $page->show();
        die(json_encode(array('result'=>0,'totalPages'=>$page->totalPages, 'orderList'=>$list)));
    }
    
    public function cancel()
    {
        if(!$this->user)
        {
            die(json_encode(array(
                'result' => 2,
            )));
        }
        $data['status'] = 4;
        $orderMod = D('Order');
        if($orderMod->where('id='.$_REQUEST['orderId'].' and user_id='.$this->user['id'])->save($data))
        {
            $order = $orderMod->where('id='.$_REQUEST['orderId'].' and user_id='.$this->user['id'])->find();
            $goodsMod = D('Goods');
            $goodsMod->IncreaseStock($order['goods_id'], $order['goods_number']);
            die(json_encode(array(
                'result' => 0,
            )));
        }
        die(json_encode(array(
            'result' => 1,
        )));
    }
    
    public function confirm()
    {
        if(!$this->user)
        {
            die(json_encode(array(
                'result' => 2,
            )));
        }
        $orderMod = D('Order');
        $data['status'] = 5;
        if($orderMod->where('id='.$_REQUEST['orderId'].' and user_id='.$this->user['id'])->save($data))
        {
            die(json_encode(array(
                'result' => 0,
            )));
        }
        die(json_encode(array(
            'result' => 1,
        )));
    }
    
    public function detail()
    {
        $orderId = $_REQUEST['orderId'];
        $orderMod = D('Order');
        $order = $orderMod->where('id='.$orderId)->find();
        $order['goods_img'] = IMG_URL.$order['goods_img'];
        
        $addressMod = D('Address');
        $address = $addressMod->where('id='.$order['address_id'])->find();
        
        $goods = array(
            'goods_id'=>$order['goods_id'],
            'goods_name'=>$order['goods_name'],
            'goods_num'=>$order['goods_num'],
            'goods_img'=>$order['goods_img'],
            'goods_price'=>$order['goods_price'],
        );
        $shipping = array(
            'shipping_name'=>$order['shipping_name'],
            'shipping_number'=>$order['shipping_number'],
        );
        die(json_encode(array(
                'result' => 0,
                'order' => $order,
                'goods' => $goods,
                'address' => $address,
                'shipping' => $shipping,
            )));
    }
}