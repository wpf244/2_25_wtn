<?php
namespace app\api\controller;

use think\Request;

class Goods extends BaseApi
{
    /**
     * 商品详情
     *
     * @return void
     */
    public function detail()
    {
        $uid=Request::instance()->header("uid");
        $url=parent::getUrl();
        $gid=input("gid");
        $re=db("goods")->field("gid,g_name,g_xprice,g_freight,g_sales,shopid,g_content")->where(["gid"=>$gid,"g_up"=>1,"g_audi"=>1])->find();
        $banner=db("goods_img")->field("image")->where(["g_id"=>$gid,"i_status"=>1])->select();
        foreach($banner as $k=>$v){
            $banner[$k]['image']=$url.$v['image'];
        }
        $shopid=$re['shopid'];
        if($shopid == 0){
            $shop=db("sys")->field("pclogo as logo,name")->where("id",1)->find();
            $shop['logo']=$url.$shop['logo'];
        }else{
            $shop=db("shop")->field("logo,name")->where("id",$shopid)->find();
            $shop['logo']=$url.$shop['logo'];
        }
        $collect=db("collect")->where(["u_id"=>$uid,"g_id"=>$gid])->find();
        if($collect){
            $collect=1;
        }else{
            $collect=0;
        }

        //商品评价
        $count=db("assess")->where(["g_id"=>$gid,"status"=>1])->count();
        
        $assess=db("assess")->alias('a')->field('number,addtime,content,image,nickname')->where("g_id=$gid and status=1")->join('user b','a.u_id = b.uid')->order('id desc')->limit("0,2")->select();
        if($assess){
            foreach ($assess as $k => $v){
                $assess[$k]['addtime']=\intval($v['addtime']);
            }
            
        }else{
            $assess=[];
        }
        //购物车数量
        $car_cou=db("car")->where("u_id",$uid)->sum("num");

        $arr=[
            'error_code'=>0,
            'msg'=>"获取成功",
            'data'=>[
                'goods'=>$re,
                'banner'=>$banner,
                'shop'=>$shop,
                'collect'=>$collect,
                "count"=>$count,
                "assess"=>$assess,
                'car_cou'=>$car_cou
            ]
        ];
        echo \json_encode($arr);

    }
    /**
    * 商品规格
    *
    * @return void
    */
    public function spec()
    {
        $url=parent::getUrl();
        $gid=input("gid");
        $goods=db("goods")->field("g_name")->where(["gid"=>$gid,"g_up"=>1,"g_audi"=>1])->find();
        $spec=db("goods_spec")->field("sid,s_name,s_xprice,s_image")->where(["g_id"=>$gid,"s_status"=>1])->order("sid asc")->select();
        foreach($spec as $k => $v){
            $spec[$k]['s_image']=$url.$v['s_image'];
        }
        $arr=[
            'error_code'=>0,
            'msg'=>"获取成功",
            'data'=>[
                'goods'=>$goods,
                'spec'=>$spec
            ]
        ];
        echo \json_encode($arr);
    }
    /**
    * 获取规格价格
    *
    * @return void
    */
    public function get_spec()
    {
       
        $sid=input('sid');
        $re=db("goods_spec")->field("s_xprice")->where("sid=$sid")->find();
    
        if($re){
            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$re
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'参数错误',
                'data'=>""
            ];
        }
        
        echo json_encode($arr);
    }
    /**
    * 收藏商品
    *
    * @return void
    */
    public function collect()
    {
        $uid=Request::instance()->header('uid');
        
            $gid=\input('gid');
            $re=db("collect")->where(["u_id"=>$uid,"g_id"=>$gid])->find();
            if($re){
                $del=db("collect")->where("id",$re['id'])->delete();
                if($del){
                    $arr=[
                        'error_code'=>0,
                        'msg'=>'操作成功',
                        'data'=>''
                    ];
                }else{
                    $arr=[
                        'error_code'=>1,
                        'msg'=>'操作失败',
                        'data'=>''
                    ];
                }
            }else{
                $data['u_id']=$uid;
                $data['g_id']=$gid;
                $rea=db("collect")->insert($data);
                if($rea){
                    $arr=[
                        'error_code'=>0,
                        'msg'=>'操作成功',
                        'data'=>''
                    ];
                }else{
                    $arr=[
                        'error_code'=>1,
                        'msg'=>'操作失败',
                        'data'=>''
                    ];
                }
            }
      
        echo \json_encode($arr);
    }
    /**
    * 评价列表
    *
    * @return void
    */
    public function goods_assess()
    {
        $gid=\input('gid');
        
        $assess=db("assess")->alias('a')->field('number,addtime,content,image,nickname')->where("g_id=$gid and status=1")->join('user b','a.u_id = b.uid')->order('id desc')->select();
        if($assess){
            foreach ($assess as $k => $v){
                $assess[$k]['addtime']=\intval($v['addtime']);
            }
            $arr=[
                'error_code'=>0,
                'msg'=>"获取成功",
                'data'=>$assess
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"暂无评价",
                'data'=>""
            ];
        }
 
        echo \json_encode($arr);
    }
    /**
    * 加入购物车
    *
    * @return void
    */
    public function add_car()
    {
        $uid=Request::instance()->header('uid');
        $gid=\input('gid');
        $num=\input('num');
        $sid=input('sid');
        $re=db("goods")->where("gid=$gid")->find();
        $res=db("goods_spec")->where("sid=$sid and g_id=$gid")->find();
        if($re && $res){
            $rec=db('car')->where("u_id=$uid and g_id=$gid and s_id=$sid")->find();
            if($rec){
                $del=db('car')->where("u_id=$uid and g_id=$gid and s_id=$sid")->setInc("num",$num);
                if($del){
                    $arr=[
                        'error_code'=>0,
                        'msg'=>"加入成功",
                        'data'=>''
                    ];
                }else{
                    $arr=[
                        'error_code'=>2,
                        'msg'=>"加入失败",
                        'data'=>''
                    ];
                }
            }else{
                $data['u_id']=$uid;
                $data['g_id']=$gid;
                $data['num']=$num;
                $data['c_name']=$re['g_name'];
                $data['c_image']=$re['g_image'];
                $data['price']=$res['s_xprice'];
                $data['s_id']=$sid;
                $data['s_name']=$res['s_name'];
                $data['shopid']=$re['shopid'];
                $rea=db("car")->insert($data);
                if($rea){
                    $arr=[
                        'error_code'=>0,
                        'msg'=>"加入成功",
                        'data'=>''
                    ];
                }else{
                    $arr=[
                        'error_code'=>2,
                        'msg'=>"加入失败",
                        'data'=>''
                    ];
                }
            }
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"系统繁忙，请稍后再试",
                'data'=>''
            ];
        }
       
        echo \json_encode($arr);
    }
    /**
    * 立即购买
    *
    * @return void
    */
    public function go_buy()
    {
        $uid=Request::instance()->header('uid');
       
        $url=parent::getUrl();
        $gid=\input('gid');
        $sid=input('sid');
        $num=\input('num');
        
        
        $arrs=array();
        //商品详情
        $re=\db("goods")->field('gid,g_name,g_image,g_xprice,g_freight')->where("gid=$gid")->find();
        $spec=db("goods_spec")->where("sid=$sid")->find();
        $re['sid']=$sid;
        $re['s_name']=$spec['s_name'];
        
        $re['g_image']=$url.$re['g_image'];
        $re['g_xprice']=$spec['s_xprice'];
        $re['x_total']=($num*$re['g_xprice']);
     
        $re['num']=\intval($num);
        
    
        //商品总金额
        $money=($re['g_xprice']*$num+$re['g_freight']);
        $arrs['moneys']=$money;
        $arrs['freight']=$re['g_freight'];
        unset($re['g_freight']);
        $arrs['goods']=[$re];
        
        $arr=[
            'error_code'=>0,
            'msg'=>"获取成功",
            'data'=>$arrs
        ];
            
     
        echo \json_encode($arr);
    }
    /**
    * 生成订单
    *
    * @return void
    */
    public function sdd()
    {
       $uid=Request::instance()->header('uid');

        $gid=input('gid');
        $sid=input('sid');
        $num=input('num');
        $aid=\input('aid');
        $freight=input("freight");
        
        $content=\input('content');
        $ob=db("car_dd");
        $old_dd=db("car_dd")->where(["gid"=>$gid,"uid"=>$uid,"status"=>0])->find();
        if($old_dd){
            $del=$ob->where(["gid"=>$gid,"uid"=>$uid,"status"=>0])->delete();
            $code=$old_dd['code'];
            $dels=$ob->where("pay",$code)->find();
            if($dels){
                $delss=$ob->where("did",$dels['did'])->delete();
            }
        }
        $good=db("goods")->where("gid=$gid")->find();
        $spec=db("goods_spec")->where("sid=$sid")->find();
        
        $arr=array();
        $arr['gid']=$gid;
        $arr['uid']=$uid;
        
        $arr['s_name']=$spec['s_name'];
        $arr['num']=$num;
        $arr['price']=$spec['s_xprice'];
        $arr['zprice']=($spec['s_xprice']*$num+$freight);
        $arr['g_name']=$good['g_name'];
        $arr['g_image']=$good['g_image'];
        $arr['shopid']=$good['shopid'];
        $arr['freight']=$freight;
        $arr['a_id']=$aid;
        
        $arr['code']="CK-".uniqid();
        $arr['time']=time();
        $arr['content']=$content;
        $re=$ob->insert($arr);
        
        $all['gid']='0';
        $all['uid']=$uid;
        $all['num']=1;
        
        $all['s_name']=$spec['s_name'];
        $all['price']=$spec['s_xprice'];
        $all['g_name']=$good['g_name'];
        $all['g_image']=$good['g_image'];;
        $all['zprice']=($spec['s_xprice']*$num+$freight);
        $all['code']="AK-".uniqid().'a';
        $all['pay']=$arr['code'];
        $all['shopid']=$good['shopid'];
        $all['freight']=$freight;
        $all['time']=time();
        $all['a_id']=$aid;
        
        $all['content']=$content;
        $rez=$ob->insert($all);
        
        $did = db('car_dd')->getLastInsID();
        if($did){
            $arr=[
            'error_code'=>0,
            'msg'=>'订单生成成功',
            'data'=>[
                'did'=>$did,   
            ]
            ];
        }else{
            $arr=[
            'error_code'=>2,
            'msg'=>'订单生成失败',
            'data'=>''
            ];
        }
      
       echo \json_encode($arr); 
    }

























}