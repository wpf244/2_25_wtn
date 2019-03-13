<?php
namespace app\api\controller;

use think\Request;

class Car extends BaseApi
{
    /**
    * 购物车列表
    *
    * @return void
    */
    public function lister()
    {
        $uid=Request::instance()->header('uid');
       
        $res=db("car")->field("shopid")->where("u_id",$uid)->group("shopid")->select();
       
        if($res){
            $url=parent::getUrl();
            $arrs=array();
            foreach($res as $k => $v){
                if($v['shopid'] == 0){
                     $arrs[$k]['shopname']=db("sys")->where("id",1)->find()['name'];
                }else{
                    $arrs[$k]['shopname']=db("shop")->where("id",$v['shopid'])->find()['name'];
                }
                $arrs[$k]['shopid']=$v['shopid'];
                $count=db("car")->where(["u_id"=>$uid,"shopid"=>$v['shopid'],"status"=>1])->count();
 
                $goods=db("car")->where(["u_id"=>$uid,"shopid"=>$v['shopid']])->select();
                $counts=count($goods);
                if($count == $counts){
                    $arrs[$k]['check']=1;
                }else{
                    $arrs[$k]['check']=0;
                }
                foreach($goods as $kk => $vv){
                    $goods[$kk]['c_image']=$url.$vv['c_image'];
                }
                $arrs[$k]['goods']=$goods;
            }
           
            $cou=\db('car')->where("u_id=$uid and status=0")->count();
            if($cou == 0){
                $checkall=1;
            }else{
                $checkall=0;
            }
            $arr=[
                'error_code'=>0,
                'data'=>[
                    'checkall'=>$checkall,
                    'goods'=>$arrs
                ]
            ];
        }else{
            $arr=[
                'error_code'=>2,
                'msg'=>"暂无数据",
                'data'=>[
                    'checkall'=>0, 
                    'goods'=>[]
                ]
            ];
        }
    

        echo \json_encode($arr);
    }
    /**
    * 修改购物车数量
    *
    * @return void
    */
    public function num()
    {
        $cid=\input('cid');
        $num=input("num");
        $re=db("car")->where("cid=$cid")->find();
        if($re){
            $res=db("car")->where("cid=$cid")->setField("num",$num);
            if($res){
                $arr=[
                    'error_code'=>0,
                    'msg'=>"操作成功",
                    'data'=>''
                ];
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>"操作失败",
                    'data'=>''
                ];
            }
        }else{
            $arr=[
                'error_code'=>2,
                'msg'=>"非法操作",
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 减少数量
    *
    * @return void
    */
    public function cut_num()
    {
        $cid=\input('cid');
        $re=db("car")->where("cid=$cid")->find();
        if($re){
            $res=db("car")->where("cid=$cid")->setDec("num",1);
            if($res){
                $arr=[
                    'error_code'=>0,
                    'msg'=>"操作成功",
                    'data'=>''
                ];
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>"操作失败",
                    'data'=>''
                ];
            }
        }else{
            $arr=[
                'error_code'=>2,
                'msg'=>"非法操作",
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 单选
    *
    * @return void
    */
    public function change()
    {
        $cid=\input('cid');
        $re=db("car")->where("cid=$cid")->find();
        if($re){
            if($re['status'] == 0){
                $res=db("car")->where("cid=$cid")->setField("status",1);
            }else{
                $res=db("car")->where("cid=$cid")->setField("status",0);
            }
            if($res){
                $arr=[
                    'error_code'=>0,
                    'msg'=>"操作成功",
                    'data'=>''
                ];
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>"操作失败",
                    'data'=>''
                ];
            }
        }else{
            $arr=[
                'error_code'=>2,
                'msg'=>"非法操作",
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 全选
    *
    * @return void
    */
    public function change_all()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $type=\input('type');
            if($type == 0){
                $res=db("car")->where("u_id=$uid")->setField("status",0);
            }else{
                $res=db("car")->where("u_id=$uid")->setField("status",1);
            }
            if($res){
                $arr=[
                    'error_code'=>0,
                    'msg'=>"操作成功",
                    'data'=>''
                ];
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>"操作失败",
                    'data'=>''
                ];
            }
        }else{
            $arr=[
                'error_code'=>2,
                'msg'=>"非法操作",
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 店铺全选
    *
    * @return void
    */
    public function shop_change_all()
    {
        $uid=Request::instance()->header('uid');
        if($uid){
            $type=input('type');
            $shopid=input("shopid");
           // var_dump(input("post."));
            if($type == 0){
                $res=db("car")->where(["u_id"=>$uid,"shopid"=>$shopid])->setField("status",0);
            }else{
                $res=db("car")->where(["u_id"=>$uid,"shopid"=>$shopid])->setField("status",1);
            }
            if($res){
                $arr=[
                    'error_code'=>0,
                    'msg'=>"操作成功",
                    'data'=>''
                ];
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>"操作失败",
                    'data'=>''
                ];
            }
        }else{
            $arr=[
                'error_code'=>2,
                'msg'=>"非法操作",
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 删除
    *
    * @return void
    */
    public function delete_car()
    {
        $uid=Request::instance()->header("uid");
        $re=db("car")->where(["u_id"=>$uid,"status"=>1])->select();;
        if($re){
            $del=db("car")->where(["u_id"=>$uid,"status"=>1])->delete();
            if($del){
                $arr=[
                    'error_code'=>0,
                    'msg'=>"操作成功",
                    'data'=>''
                ];
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>"操作失败",
                    'data'=>''
                ];
            }
        }else{
            $arr=[
                'error_code'=>2,
                'msg'=>"非法操作",
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 去结算
    *
    * @return void
    */
    public function buy()
    {
        $uid=Request::instance()->header('uid');
    
            $res=db("car")->where("u_id=$uid and status=1")->select();
            $arrs=array();
            $url=parent::getUrl();
            $moneys=0;
            foreach ($res as $k => $v){
                $arrs[$k]['g_name']=$v['c_name'];
                $arrs[$k]['g_image']=$url.$v['c_image'];
                $arrs[$k]['g_xprice']=$v['price'];
                $arrs[$k]['num']=$v['num'];
                $arrs[$k]['s_name']=$v['s_name'];
                
                $money=($v['price']*$v['num']);
                $arrs[$k]['x_total']=$money;
                $moneys+=$money;

                $gids[]=$v['g_id'];
            }
            $freight=db("goods")->where("gid","in",$gids)->sum('g_freight');
            
            $moneys=$moneys+$freight;
            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>[
                    'moneys'=>$moneys,
                    'freight'=>$freight,
                    'goods'=>$arrs,
                ]
            ];
       
        echo \json_encode($arr);
    }
    /**
    * 生成订单
    *
    * @return void
    */
    public function pan()
    {
        $uid=Request::instance()->header('uid');

            $aid=\input('aid');
            $content=\input('content');
           // $freight=input("freight");
            $freight=0;
            $gnames="";
            $zprices=0;

            $shop=db("car")->field("shopid")->where(["u_id"=>$uid,"status"=>1])->group("shopid")->select();
            foreach($shop as $kk => $vv){
                $gname="";
                $zprice=0;
               
                $res=db("car")->where(["u_id"=>$uid,"status"=>1,"shopid"=>$vv['shopid']])->select();     
                foreach ($res as $k=>$v){
                   $arr=array();
                   $arr['gid']=$v['g_id'];
                   $arr['uid']=$v['u_id'];
                   $arr['num']=$v['num'];
                   $arr['price']=$v['price'];
                   $arr['zprice']=($v['price']*$v['num']);
                   $arr['g_name']=$v['c_name'];
                   $arr['g_image']=$v['c_image'];
                   $arr['s_name']=$v['s_name'];
                   $arr['a_id']=$aid;
                   $arr['shopid']=$v['shopid'];
                   $arr['code']="CK-".uniqid();
                   $arr['time']=time();
                   $arr['content']=$content;
                   $goods=db("goods")->where("gid",$v['g_id'])->find();

               
                    $re=db('car_dd')->insert($arr);
                    
                    $str[$k]=$arr['code'];
                    $zprice+=$arr['zprice'];
                    $gname.=$v['c_name'];
                    $freight+=$goods['g_freight'];
                    //$del=db('car')->where("cid={$v['cid']}")->delete();
                }
                
               

                $str1=implode(',', $str);
                $all['gid']='0';
                $all['uid']=$uid;
                $all['num']=1;
                $all['zprice']=$zprice+$freight;
                $all['freight']=$freight;
                $all['g_name']=$gname;
                $all['code']="AK-".uniqid().'a';
                $all['pay']=$str1;
                $all['time']=time();
                $all['a_id']=$aid;
                $all['shopid']=$vv['shopid'];
                $all['content']=$content;
                $re=db('car_dd')->insert($all);

                $code[$kk]=$all['code'];
                $strs[$kk]=$all['pay'];
                $zprices+=$all['zprice'];
                $gnames.=$all['g_name'];

            }

            
           
            $str2=implode(',', $code);
            $str3=implode(',', $strs);
            $alls['gid']='-1';
            $alls['uid']=$uid;
            $alls['num']=1;
            $alls['zprice']=$zprices;
           
            $alls['g_name']=$gnames;
            $alls['code']="AKS-".uniqid().'a';
            $alls['pay']=$str2.','.$str3;
            $alls['time']=time();
            $alls['a_id']=$aid;
            $alls['content']=$content;
            $re=db('car_dd')->insert($alls);
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