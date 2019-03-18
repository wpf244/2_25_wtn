<?php
namespace app\api\controller;

use think\Request;


class Courier extends Common
{
    /**
    * 待取件快递
    *
    * @return void
    */
    public function lister()
    {
       $uid=Request::instance()->header("uid");
       $user=db("user")->where("uid",$uid)->find();
       $phone=$user['phone'];
       $courier=db("courier")->where("phone",$phone)->find();
       if($courier){
           $aid=$courier['aid'];
           $eid=$courier['eid'];
           $sark=db("sark")->where("aid",$aid)->select();
           $arr=array();
           foreach($sark as $k => $v){
               $arr[]=$v['code'];
           }
           $res=db("express_dd")->where(["e_id"=>$eid,"status"=>2,"type"=>0,"number"=>["in",$arr]])->select();
           foreach($res as $kk => $vv){
               $res[$kk]['ji_addr']=db("mailing_addr")->field("name,phone,addr")->where("mid",$vv['j_id'])->find();
               $res[$kk]['shou_addr']=db("mailing_addr")->field("name,phone,addr")->where("mid",$vv['s_id'])->find();
               $res[$kk]['express']=db("express")->field("ex_name")->where("ex_id",$vv['e_id'])->find();
           }
           if($res){
            $arr=[
                'error_code'=>0,
                'msg'=>"获取成功",
                'data'=>$res
            ]; 
           }else{
            $arr=[
                'error_code'=>2,
                'msg'=>"暂无数据",
                'data'=>''
            ];
           }
       }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"此用户不是快递员",
                'data'=>''
            ];
       }
       echo json_encode($arr);
    }







}