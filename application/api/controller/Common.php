<?php
namespace app\api\controller;

use think\Controller;
use think\Request;


class Common extends Controller
{
    public function _initialize()
    {
        $token=Request::instance()->header('token');
         if($token != '50a00a9b8d3402ed4f1b3ed4b890294b'){
             $arrs=[
                 'error_code'=>500,
                 'msg'=>"获取成功",
                 'data'=>''
             ];
             echo \json_encode($arrs);exit;
         }
         $uid=Request::instance()->header('uid');
         if(empty($uid)){
            $arrs=[
                'error_code'=>501,
                'msg'=>"请先登录",
                'data'=>''
            ];
            echo \json_encode($arrs);exit;
         }else{
             $user=db("user")->where("uid",$uid)->find();
             if(empty($user)){
                $arrs=[
                    'error_code'=>502,
                    'msg'=>"登录信息已失效",
                    'data'=>''
                ];
                echo \json_encode($arrs);exit;
             }else{
                 if(empty($user['phone'])){
                    $arrs=[
                        'error_code'=>503,
                        'msg'=>"请先绑定手机号码",
                        'data'=>''
                    ];
                    echo \json_encode($arrs);exit;
                 }
             }
         }
    }
    public function getUrl(){
        $url=Request::instance()->domain();
        
        return $url;
    }
}