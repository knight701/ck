<?php

class GoodsModel extends RelationModel {
    protected $tableName = 'goods';
    
    public function listGoods($catId, $keyWords, $pageSize)
    {
        $where = "status=1";
        if($catId)
        {
            $where .= ' and cat_id='.$catId;
        }
        if($keyWords)
        {
            $where .= ' and goods_name like "%'.$keyWords.'%"';
        }
        $count = $this->where($where)->count();
        $page = new Page($count, $pageSize);
        $goodsList = $this->where($where)->order('add_time')->limit($page->firstRow . ',' . $page->listRows)->select();
        foreach ($goodsList as $k=>$v)
        {
            $goodsList[$k]['goods_img'] = IMG_URL.$v['goods_img'];
            $goodsList[$k]['goods_thumb'] = IMG_URL.$v['goods_thumb'];
        }
        $result['goodsList'] = $goodsList;
        $result['totalPages'] = $page->totalPages;
        return $result;
    }
        
    public function goodsDetail($goods_id)
    {
        $goods = $this->where('id='.$goods_id)->find();
        $goods['goods_img'] = IMG_URL.$goods['goods_img'];
        $goods['goods_thumb'] = IMG_URL.$goods['goods_thumb'];
        $goodsImgMod = D('GoodsImg');
        $goodsImgList = $goodsImgMod->where('goods_id='.$goods_id)->select();
        foreach ($goodsImgList as $k=>$v)
        {
            $goodsImgList[$k]['goods_img'] = IMG_URL.$v['goods_img'];
            $goodsImgList[$k]['goods_thumb'] = IMG_URL.$v['goods_thumb'];
        }
        $goods['goodsGallery'] = $goodsImgList;
        return $goods;
    }
    
    public function getGoods($goods_id)
    {
        return $this->where('id='.$goods_id)->find();
    }
    
    public function decreaseStock($goodsId, $goodsNum)
    {
        $stock = $this->where('id='.$goodsId)->getField('stock');
        if($stock>=$goodsNum)
        {
            return $this->where('id='.$goodsId)->setDec('stock',$goodsNum);
        }
        return  FALSE;
    }
    
    public function IncreaseStock($goodsId, $goodsNum)
    {
        return $this->where('id='.$goodsId)->setInc('stock',$goodsNum);
    }
}

?>