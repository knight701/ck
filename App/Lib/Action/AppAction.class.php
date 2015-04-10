<?php
class AppAction extends BaseAction {
    
    public function checkUpdate()
    {
        $platform = $_REQUEST['platform'];
        $appMod = D('App');
        $appVersion = $appMod->where('platform="'.$platform.'"')->find();
        die(json_encode(array('result'=>0,'appVersion'=>$appVersion)));
    }
}