<?php
namespace app\api\controller;

use think\Request;

class Shop extends BaseApi
{
    /**
     * 店铺主页
     *
     * @return void
     */
    public function index()
    {
        $shopid=input("shopid");
        $uid=Request::instance()->header('uid');
        if($shopid == 0){
            $re=db("sys")->field("name,pclogo as logo,waplogo as image,follow")->where("id",1)->find();
        }else{
            $re=db("shop")->field("name,logo,image,follow")->where("id",$shopid)->find();
        }
        $url=parent::getUrl();
        $re['logo']=$url.$re['logo'];
        $re['image']=$url.$re['image'];

        $user=db("shop_collect")->where(["uid"=>$uid,"shopid"=>$shopid])->find();
        if($user){
            $re['collect']=1;
        }else{
            $re['collect']=0;
        }

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
    /**
     * 热门推荐
     *
     * @return void
     */
    public function search()
    {
        $shopid=input("shopid");
        $res=db("hot")->field("name")->where(["shopid"=>$shopid,"status"=>1])->select();
        $arr=[
            'error_code'=>0,
            'msg'=>"获取成功",
            'data'=>$res
        ];
        echo json_encode($arr);
    }
    /**
     * 店铺搜索列表
     *
     * @return void
     */
    public function search_lister()
    {
        $url=parent::getUrl();
        $keywords=input("keywords");
        $shopid=input("shopid");
       
        
        $goods=db("goods")->field("gid,g_name,g_xprice,desc,tag,g_sales,g_thumb,shopid")->where(["g_up"=>1,"g_audi"=>1])->where("g_name","like","%".$keywords."%")->where("shopid",$shopid)->select();
        foreach($goods as $k => $v){
            $goods[$k]['g_thumb']=$url.$v['g_thumb'];
            $tag=explode("@",$v['tag']);
            $goods[$k]['tag']=$tag;
        }
        if($goods){
            $arr=[
                'error_code'=>0,
                'msg'=>"获取成功",
                'data'=>$goods
            ];
        
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"暂无数据",
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
     * 店铺关注
     */
     public function collect()
     {
         $uid=Request::instance()->header("uid");
         $shopid=input("shopid");
         $collect=input("collect");
         if($shopid == 0){
             if($collect == 0){
                 db("sys")->where("id",1)->setDec("follow",1);
                 $re=db("shop_collect")->where(["uid"=>$uid,"shopid"=>$shopid])->find();
                 if($re){
                     $res=db("shop_collect")->where(["uid"=>$uid,"shopid"=>$shopid])->delete();
                 }
                 $arr=[
                    'error_code'=>0,
                    'msg'=>"取消收藏成功",
                    'data'=>''
                ];
             }else{
                db("sys")->where("id",1)->setInc("follow",1);
                $re=db("shop_collect")->where(["uid"=>$uid,"shopid"=>$shopid])->find();
                if(empty($re)){
                    $data['uid']=$uid;
                    $data['shopid']=$shopid;
                    db("shop_collect")->insert($data);
                }
                $arr=[
                    'error_code'=>0,
                    'msg'=>"收藏成功",
                    'data'=>''
                ];
             }
         }else{
            if($collect == 0){
                db("shop")->where("id",$shopid)->setDec("follow",1);
                $re=db("shop_collect")->where(["uid"=>$uid,"shopid"=>$shopid])->find();
                if($re){
                    $res=db("shop_collect")->where(["uid"=>$uid,"shopid"=>$shopid])->delete();
                }
                $arr=[
                    'error_code'=>0,
                    'msg'=>"取消收藏成功",
                    'data'=>''
                ];
            }else{
               db("shop")->where("id",$shopid)->setInc("follow",1);
               $re=db("shop_collect")->where(["uid"=>$uid,"shopid"=>$shopid])->find();
               if(empty($re)){
                   $data['uid']=$uid;
                   $data['shopid']=$shopid;
                   db("shop_collect")->insert($data);
               }
               $arr=[
                'error_code'=>0,
                'msg'=>"收藏成功",
                'data'=>''
            ];
            }
         }
        
    
        echo \json_encode($arr);        
     }


}