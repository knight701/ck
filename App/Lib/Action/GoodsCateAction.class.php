<?php
class GoodsCateAction extends BaseAction {
    
    public function lists()
    {
        $cateMod = D('GoodsCate');
        $cateList = $cateMod->listCategory();
        die(json_encode(array('result'=>0,'categoryList'=>$cateList)));
    }
}