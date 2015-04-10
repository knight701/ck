<?php

class OrderModel extends RelationModel {
    protected $tableName = 'order';
    
    public function addOrder($order)
    {
        $goodsMod = D('Goods');
        $dbGoods = $goodsMod->getGoods($order['goods_id']);
        $orderSn = getOrderSn();
        $orderAmount = $dbGoods['price']*$order['goods_num'];
        $data = array(
            'order_sn' => $orderSn,
            'goods_id' => $order['goods_id'],
            'goods_name' => $dbGoods['goods_name'],
            'goods_img' => $dbGoods['goods_thumb'],
            'goods_number' => $order['goods_num'],
            'goods_price' => $dbGoods['price'],
            'user_id' => $order['user_id'],
            'address_id' => $order['address_id'],
            'order_amount' => $orderAmount,
            'shipping_fee' => $order['shipping_fee'],
            'discount' => $order['discount'],
            'add_time' => time(),
            'status' => 1,
            'message' => $order['message'],
        );
        if($this->create($data))
        {
            //商品减库存
            $goodsMod = D('Goods');
            if($goodsMod->decreaseStock($order['goods_id'], $order['goods_num']))
            {
                $this->add();
                return TRUE;
            }
            return FALSE;
        }
        return FALSE;
    }
}

?>