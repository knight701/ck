<?php
class GoodsAction extends BaseAction {
    
    public function lists()
    {
        import('ORG.Util.Page'); // 导入分页类
        $catId = $_REQUEST['catId'];
        $keyWords = $_REQUEST['keyWords'];
        $pageSize = $_REQUEST['pageSize'];
        
        $goodsMod = D('Goods');
        $result = $goodsMod->listGoods($catId, $keyWords, $pageSize);
        die(json_encode(array('result'=>0,'totalPages'=>$result['totalPages'], 'goodsList'=>$result['goodsList'])));
    }
    
    public function detail()
    {
        $goodsId = $_REQUEST['goodsId'];
        $goodsMod = D('Goods');
        $goods = $goodsMod->goodsDetail($goodsId);
        die(json_encode(array('result'=>0,'goods'=>$goods)));
    }
}