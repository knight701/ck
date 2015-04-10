<?php

class GoodsCateModel extends RelationModel {
    protected $tableName = 'category';
    
    public function listCategory()
    {
        $cateList = $this->where('status=1')->order('sort')->select();
        $parentArr = array();
        foreach ($cateList as $k=>$v)
        {
            $tmpArr = array();
            if($v['parent_id']==0)
            {
                $parentArr[] = $v;
            }
        }
        
        foreach($parentArr as $k=>$v)
        {
            $childArr = array();
            foreach ($cateList as $k1=>$v1)
            {
                $childCateArr = array();
                if($v1['parent_id']==$v['id'])
                {
                    $childArr[] = $v1;
                }
            }
            $parentArr[$k]['childCate'] = $childArr;
        }
        
        return $parentArr;
    }
}

?>