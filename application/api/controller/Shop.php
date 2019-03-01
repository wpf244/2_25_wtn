<?php
namespace app\api\controller;

class Shop extends BaseApi
{
    public function index()
    {
        $shopid=input("shopid");
        if($shopid == 0){
            $re=db("sys")->field("name,pclogo as logo,waplogo as image,follow")->where("id",1)->find();
        }else{
            $re=db("shop")->field("name,logo,image,follow")->where("id",1)->find();
        }
        $url=parent::getUrl();
        $re['logo']=$url.$re['logo'];
        $re['image']=$url.$re['image'];

        $goods=db("goods")->field("gid,g_name,g_xprice,desc,tag,g_sales,g_thumb,shopid")->where(["g_up"=>1,"g_audi"=>1,"shopid"=>$shopid])->order(["g_sort asc","gid desc"])->select();
        foreach($goods as $k => $v){
            $goods[$k]['g_thumb']=$url.$v['g_thumb'];
            $tag=explode("@",$v['tag']);
            $goods[$k]['tag']=$tag;
        }
        $arr=[
            'error_code'=>0,
            'msg'=>"获取成功",
            'data'=>[
                'shop'=>$re,
                'goods'=>$goods
            ]
        ];
        echo json_encode($arr);
    }
}