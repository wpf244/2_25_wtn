<?php
namespace app\api\controller;

use think\Controller;


class Plan extends Controller
{
    //发货七天后 默认收货
    public function index()
    {
       $res=db("car_dd")->where(['gid'=>0,'status'=>2])->select();
       $time=60*60*24*7;
       $times=time();
       foreach($res as $k => $v){
           if(empty($v['fa_time']) || ($times-$v['fa_time']) >= $time){
            $res=db('car_dd')->where("did",$v['did'])->setField("status",3);

            $shopid=$v['shopid'];
            if($shopid != 0){
                $money=$v['zprice'];
                db("shop")->where("id",$shopid)->setInc("money",$money);

                //增加商户收支明细
                $data['shopid']=$shopid;
                $data['money']=$money;
                $data['did']=$v['did'];
                $data['time']=time();
                $data['status']=1;
                db("moneys_log")->insert($data);
            }

            $pay=$v['pay'];
            $pays=\explode(",", $pay);
            
            $res=db('car_dd')->where(array('code'=>array('in',$pays)))->select();
            if($res){
                $dels=db('car_dd')->where(array('code'=>array('in',$pays)))->setField("status",3);
            }
           } 
       }
    }
}