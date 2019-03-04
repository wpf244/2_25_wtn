<?php
namespace app\api\controller;

use think\Controller;
use think\Request;

class Login extends Controller
{
    public function login()
    {
        $token=Request::instance()->header('token');
        if($token != '50a00a9b8d3402ed4f1b3ed4b890294b'){
            $arrs=[
                'error_code'=>500,
                'msg'=>'token验证失败',
                'data'=>''
            ];
            echo \json_encode($arrs);exit;
        }

        $code=input('code');

        $fid = Request::instance()->param('fid', 0);
        if($fid != 0){
            $data['fid']=$fid;
        }

        $url="https://api.weixin.qq.com/sns/jscode2session?appid=wx0bf6a1d285ef4fc8&secret=32cded6845fe0735fea052ab0e415d1e&js_code=".$code."&grant_type=authorization_code";
        $results=json_decode(file_get_contents($url),true);
        $openid=$results['openid'];
        if(!$openid){
            $arr=[
                'error_code'=>1,
                'msg'=>'openID获取失败',
                'data'=>''
            ];
        }else{
            
            $data['openid']=$openid;
            $data['nickname']=\input('nickname');
            $data['image']=\input('image');
            $data['time']=\time();
            $ret=db('user')->where(array('openid'=>$openid))->find();
            if($ret['openid']){
                $res=db("user")->where(array('openid'=>$openid))->update($data);
                    $arr=[
                        'error_code'=>0,
                        'msg'=>'授权成功',
                        'data'=>[
                            'uid'=>$ret['uid'],
                        ]
                    ];
            }else{
                $rea=db('user')->insert($data);
                $uid=db('user')->getLastInsID();
                if($rea){
                    $arr=[
                        'error_code'=>0,
                        'msg'=>'授权成功',
                        'data'=>[
                            'uid'=>$uid,
                        ]
                    ];
    
                }else{
                    $arr=[
                        'error_code'=>2,
                        'msg'=>'授权失败',
                        'data'=>''
                    ];
                }
               
            }
        }
        echo \json_encode($arr);
    }
    public function logo()
    {
        $re=db("sys")->field("pclogo")->where("id",1)->find();
        $url=Request::instance()->domain();
        $re['pclogo']=$url.$re['pclogo'];
        $arrs=[
            'error_code'=>0,
            'msg'=>"获取成功",
            'data'=>$re
        ];
        echo \json_encode($arrs);
    }
}