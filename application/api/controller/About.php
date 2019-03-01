<?php
namespace app\api\controller;

class About extends BaseApi
{
    public function index()
    {
        $re=db("sys")->field("pclogo,content")->where("id",1)->find();
        $url=parent::getUrl();
        $re['pclogo']=$url.$re['pclogo'];
        $arrs=[
            'error_code'=>0,
            'msg'=>"获取成功",
            'data'=>$re
        ];
        echo \json_encode($arrs);
    }
}