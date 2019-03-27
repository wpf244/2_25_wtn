<?php
namespace app\api\controller;

use think\Request;


class Express extends Common
{
    /**
    * 绑定快递柜
    *
    * @return void
    */
    public function user_express()
    {
        $uid=Request::instance()->header("uid");
        $phone=db("user")->where("uid",$uid)->find()['phone'];
        $code=input("code");
        $sark=db("sark")->where("code",$code)->find();
        if($sark){
            $phones=$sark['phone'];
            $arr=\explode("@",$phones);
            if(in_array($phone,$arr)){

                $res=db("user")->where("uid",$uid)->setField("code",$code);
                if($res){
                    $arr=[
                        'error_code'=>0,
                        'msg'=>"绑定成功",
                        'data'=>''
                    ];
                }else{
                    $arr=[
                        'error_code'=>3,
                        'msg'=>"绑定失败",
                        'data'=>''
                    ];
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>"此快递柜未录入此手机号码",
                    'data'=>''
                ];
            }

        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"此快递柜信息未录入",
                'data'=>''
            ];
        }
        echo json_encode($arr);
    }
    /**
    * 快递柜状态
    *
    * @return void
    */
    public function express_status()
    {
        $uid=Request::instance()->header("uid");
        $code=db("user")->where("uid",$uid)->find()['code'];
        if($code){
            $sark=db("sark")->alias("a")->field("a.*,a.id as aid,b.*,b.id as bid")->where("code",$code)->join("sark_firm b","b.id = a.fid")->find();
            if($sark){
                $arr=[
                    'error_code'=>0,
                    'msg'=>"获取成功",
                    'data'=>$sark
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>"快递柜信息不存在",
                    'data'=>''
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"此用户未绑定快递柜",
                'data'=>''
            ];
        }
        echo json_encode($arr);
    }
    /**
    * 修改状态
    *
    * @return void
    */
    public function change_status()
    {
        $uid=Request::instance()->header("uid");
        $id=input("id");
        $data['status']=input("status");
        $sark=db("sark")->where("id",$id)->find();
        if($sark){
           $res=db("sark")->where("id",$id)->update($data);
           if($res){
            $arr=[
                'error_code'=>0,
                'msg'=>"操作成功",
                'data'=>''
            ];
           }else{
            $arr=[
                'error_code'=>2,
                'msg'=>"操作失败",
                'data'=>''
            ];
           }
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"非法操作",
                'data'=>''
            ]; 
        }
        echo json_encode($arr);
    }
    
    /**
    * 判断用户类型
    *
    * @return void
    */
    public function user_type()
    {
        $uid=Request::instance()->header("uid");
        $user=db("user")->where("uid",$uid)->find();
        if($user['code']){
            $code=$user['code'];
            $sark=db("sark")->where("code",$code)->find();
            if($sark){
                $arr=[
                    'error_code'=>0,
                    'msg'=>"业主",
                    'data'=>''
                ];
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>"其他人",
                    'data'=>''
                ];
            }
        }else{
            $phone=$user['phone'];
            $res=db("sark")->field("phone")->select();
            foreach($res as $k => $v){
                $phones=$v['phone'];
                $arr=explode("@",$phones);
                if(\in_array($phone,$arr)){
                    $arr=[
                        'error_code'=>0,
                        'msg'=>"业主",
                        'data'=>''
                    ];
                    echo json_encode($arr);exit;
                }else{
                    $arr=[
                        'error_code'=>1,
                        'msg'=>"其他人",
                        'data'=>''
                    ];
                }
            }
        }
        echo json_encode($arr);
    } 
    /**
    * 业主下单
    *
    * @return void
    */
    public function save()
    {
        $uid=Request::instance()->header("uid");
        $data['number']=input("code");
        $data['u_id']=$uid;
        $data['time']=time();
        $data['code']=date("YmdHis");
        $data['type']=0;
        $data['money']=db("free")->where("id",2)->find()['num']; 
        $data['status']=1;  
        db("express_dd")->insert($data);
        $did=db("express_dd")->getLastInsID();

        $arr=[
            'error_code'=>0,
            'msg'=>"下单成功",
            'data'=>['did'=>$did]
        ];
        
        echo json_encode($arr);

    }
    /**
    * 业主开锁
    *
    * @return void
    */
    public function user_unlock()
    {
        $uid=Request::instance()->header("uid");
        $did=input("did");
        $dd=db("express_dd")->where(["u_id"=>$uid,"id"=>$did])->find();
        $code=input("code");
        $re=db("sark")->alias("a")->field("a.*,b.*,b.id as bid,b.firm_code as firm")->where("code",$code)->join("sark_firm b","b.id = a.fid")->find();
        if($re){
        //    $re['firm']=db("sark_firm")->where("id",$re['fid'])->find()['firm_name'];
            if($dd){
                if($dd['status'] == 1){
                    if($dd['type'] == 0){
                        $arr=[
                            'error_code'=>0,
                            'msg'=>"可以开锁",
                            'data'=>$re
                        ];
                    }else{
                        $arr=[
                            'error_code'=>3,
                            'msg'=>"订单状态异常",
                            'data'=>''
                        ];
                    }
                }else{
                    $arr=[
                        'error_code'=>2,
                        'msg'=>"订单未支付",
                        'data'=>''
                    ];
                }
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>"订单异常",
                    'data'=>''
                ];
            }
        }else{
            $arr=[
                'error_code'=>4,
                'msg'=>"快递柜信息没有录入",
                'data'=>''
            ];
        }
        
        echo json_encode($arr);
    }
    /**
    * 开锁成功
    *
    * @return void
    */
    public function user_unlock_success()
    {
        $did=input("did");
        $status=input("status");
        $re=db("express_dd")->where("id",$did)->find();
        if($re){
            if($status == 1){
               //开锁成功
               db("express_dd")->where("id",$did)->setField("status",2);
               $code=$re['number'];
               db("sark")->where("code",$code)->setField("status",1);
               $arr=[
                'error_code'=>0,
                'msg'=>"开锁成功",
                'data'=>''
               ];
            }
            if($status == 2){
                $arr=[
                    'error_code'=>2,
                    'msg'=>"开锁失败",
                    'data'=>''
                   ];
            }
           
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"订单异常",
                'data'=>''
            ];
        }
        echo json_encode($arr);

    }

    /**
    * 其他人下单
    *
    * @return void
    */
    public function other_save()
    {
        $uid=Request::instance()->header("uid");
        $code=input("code");
       
        $re=db("sark")->where("code",$code)->find();
        if($re['status'] == 1){
            $data['number']=$code;
            $data['u_id']=$uid;
            $data['time']=time();
            $data['code']=date("YmdHis");
            $data['type']=1;
            $data['money']=db("free")->where("id",2)->find()['num']; 
            $num=db("free")->where("id",1)->find()['num'];
            $free_num=db("user")->where("uid",$uid)->find()['free_num'];
            if($free_num < $num){
                $data['status']=1;
                db("user")->where("uid",$uid)->setInc("free_num",1);
            } 
            db("express_dd")->insert($data);
            $did=db("express_dd")->getLastInsID();
    
            $arr=[
                'error_code'=>0,
                'msg'=>"下单成功",
                'data'=>['did'=>$did]
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"柜子已占用无法开锁,请联系业主",
                'data'=>''
            ];
        }
       
        
        echo json_encode($arr);

    }

    /**
    * 判断订单是否支付
    *
    * @return void
    */
    public function jugde_dd()
    {
        $did=input("did");
        $re=db("express_dd")->where("id",$did)->find();
        if($re){
            if($re['status'] == 1){
                $arr=[
                    'error_code'=>0,
                    'msg'=>"订单已支付,去开锁",
                    'data'=>['did'=>$did]
                ];
            }elseif($re['status'] == 0){
                $arr=[
                    'error_code'=>1,
                    'msg'=>"订单未支付,去支付",
                    'data'=>['did'=>$did]
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>"非法请求",
                    'data'=>''
                ];
            }
        }else{
            $arr=[
                'error_code'=>2,
                'msg'=>"非法请求",
                'data'=>''
            ];
        }
        
        echo json_encode($arr);
    }
    /**
    * 其他人开锁
    *
    * @return void
    */
    public function other_unlock()
    {
        $uid=Request::instance()->header("uid");
        $did=input("did");
        $dd=db("express_dd")->where(["u_id"=>$uid,"id"=>$did])->find();

        $code=input("code");
        $re=db("sark")->alias("a")->field("a.*,b.*,b.id as bid,b.firm_code as firm")->where("code",$code)->join("sark_firm b","b.id = a.fid")->find();

        if($re){
         //   $re['firm']=db("sark_firm")->where("id",$re['fid'])->find()['firm_name'];
            if($dd){
                if($dd['status'] == 1){
                    if($dd['type'] == 1){
                        //判断箱子状态
                        $code=$dd['number'];
                        $res=db("sark")->where("code",$code)->find();
                        if($res['status'] == 1){
                            $arr=[
                                'error_code'=>0,
                                'msg'=>"可以开锁",
                                'data'=>$re
                            ];
                        }else{
                            $arr=[
                                'error_code'=>4,
                                'msg'=>"柜子已占用,请联系业主",
                                'data'=>''
                            ];
                        }
                        
                    }else{
                        $arr=[
                            'error_code'=>3,
                            'msg'=>"订单状态异常",
                            'data'=>''
                        ];
                    }
                }else{
                    $arr=[
                        'error_code'=>2,
                        'msg'=>"订单未支付",
                        'data'=>''
                    ];
                }
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>"订单异常",
                    'data'=>''
                ];
            }
        }else{
            $arr=[
                'error_code'=>4,
                'msg'=>"快递柜信息没有录入",
                'data'=>''
            ];
        }

        
        echo json_encode($arr);
    }

    /**
    * 开锁成功
    *
    * @return void
    */
    public function other_unlock_success()
    {
        $did=input("did");
        $status=input("status");
        $re=db("express_dd")->where("id",$did)->find();
        if($re){
            if($status == 1){
               //开锁成功
               db("express_dd")->where("id",$did)->setField("status",2);
               $code=$re['number'];
               db("sark")->where("code",$code)->setField("status",0);
               $arr=[
                'error_code'=>0,
                'msg'=>"开锁成功",
                'data'=>''
               ];
            }
            if($status == 2){
                $arr=[
                    'error_code'=>2,
                    'msg'=>"开锁失败",
                    'data'=>''
                   ];
            }
           
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"订单异常",
                'data'=>''
            ];
        }
        echo json_encode($arr);

    }

    /**
    * 用户寄件开锁
    *
    * @return void
    */
    public function express_unlock()
    {
        $uid=Request::instance()->header("uid");
        $did=input("did");
        $code=input("code");
        $dd=db("express_dd")->where("id",$did)->find();
        if($dd['status'] == 1){
            $sark=db("sark")->where("code",$code)->find();
            if($sark){
                $user=db("user")->where("uid",$uid)->find();
                $user_phone=$user['phone'];
                $phone=$sark['phone'];
                $phones=explode("@",$phone);
                if(\in_array($user_phone,$phones)){
                    $dds=db("express_dd")->where(["u_id"=>$uid,"status"=>2,"type"=>0])->find();
                    if(!$dds){
                        $ddss=db("express_dd")->where(["number"=>$code,"status"=>2,"type"=>1])->find();
                        if(!$ddss){
                          //   $data['status']=2;
                             $data['number']=$code;
                             $res=db("express_dd")->where("id",$did)->update($data);
                             if($res){
                                $arr=[
                                    'error_code'=>0,
                                    'msg'=>"可以开锁",
                                    'data'=>[
                                        'did'=>$did
                                    ]
                                ]; 
                             }else{
                                $arr=[
                                    'error_code'=>6,
                                    'msg'=>"系统繁忙稍后再试",
                                    'data'=>''
                                ]; 
                             }
                        }else{
                            $arr=[
                                'error_code'=>5,
                                'msg'=>"到件未取出,不能开锁",
                                'data'=>''
                            ]; 
                        }  
                    }else{
                        $arr=[
                            'error_code'=>4,
                            'msg'=>"已有发件未取出,不能开锁",
                            'data'=>''
                        ]; 
                    }
                }else{
                    $arr=[
                        'error_code'=>3,
                        'msg'=>"用户手机号未绑定,不能开锁",
                        'data'=>''
                    ];  
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>"快递柜信息未录入,不能开锁",
                    'data'=>''
                ]; 
            }
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"订单状态异常,不能开锁",
                'data'=>''
            ];
        }
        echo json_encode($arr);
    }
    /**
    * 开锁成功
    *
    * @return void
    */
    public function unlock_success()
    {
        $did=input("did");
        $re=db("express_dd")->where("id",$did)->find();
        if($re){
            if($re['status'] == 1){
                $data['status']=2;
                $data['f_time']=time();
               $res=db("express_dd")->where("id",$did)->update($data);
               if($res){
                $arr=[
                    'error_code'=>0,
                    'msg'=>"订单状态修改成功",
                    'data'=>''
                ];
               }else{
                $arr=[
                    'error_code'=>3,
                    'msg'=>"订单状态修改失败",
                    'data'=>''
                ];
               }
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>"订单状态异常",
                    'data'=>''
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"订单异常",
                'data'=>''
            ];
        }
        echo json_encode($arr);

    } 
    /**
    * 其他人下单
    *
    * @return void
    */
    public function saves()
    {
        $uid=Request::instance()->header("uid");
        $re=db("express_dd")->where(["u_id"=>$uid,"status"=>0,"type"=>0])->find();
        if($re){
            db("express_dd")->where("id",$re['id'])->delete();
        }
        $data=input("post.");
        $data['u_id']=$uid;
        $data['time']=time();
        $data['code']=date("YmdHis");
        $data['type']=0;
        $data['money']=db("free")->where("id",2)->find()['num'];
        $num=db("free")->where("id",1)->find()['num'];
        $free_num=db("user")->where("uid",$uid)->find()['free_num'];
        if($free_num < $num){
            $data['status']=1;
            db("user")->where("uid",$uid)->setInc("free_num",1);
        }
        db("express_dd")->insert($data);
        $did=db("express_dd")->getLastInsID();

        $arr=[
            'error_code'=>0,
            'msg'=>"下单成功",
            'data'=>['did'=>$did]
        ];
        
        echo json_encode($arr);

    }
/**
    * 寄快递
    *
    * @return void
    */
    public function index()
    {
        //快递公司
        $express=db("express")->where("ex_status",1)->select();
        if($express){
            $arr=[
                'error_code'=>0,
                'msg'=>"获取成功",
                'data'=>$express
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"暂无数据",
                'data'=>''
            ];
        }
        echo json_encode($arr);
    }
    /**
    * 寄件人收货地址列表
    *
    * @return void
    */
    public function mailing_addr_lister()
    {
        $uid=Request::instance()->header("uid");
        $status=input("status");
        $res=db("mailing_addr")->where(["u_id"=>$uid,"status"=>$status])->select();
        if($res){
           $arr=[
               'error_code'=>0,
               'msg'=>"获取成功",
               'data'=>$res
           ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"暂无数据",
                'data'=>''
            ];
        }
        echo json_encode($arr);
    }
    /**
    * 保存寄件人地址
    *
    * @return void
    */
    public function mailing_addr_save()
    {
        $uid=Request::instance()->header("uid");
        $data=input("post.");
        $data['u_id']=$uid;
        $re=db("mailing_addr")->insert($data);
        if($re){
            $arr=[
                'error_code'=>0,
                'msg'=>"保存成功",
                'data'=>''
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"保存失败",
                'data'=>''
            ];
        }
        echo json_encode($arr);
    }
    /**
    * 地址详情
    *
    * @return void
    */
    public function mailing_addr_detail()
    {
        $uid=Request::instance()->header("uid");
        $mid=input("mid");
        $re=db("mailing_addr")->where(["u_id"=>$uid,"mid"=>$mid])->find();
        if($re){
            $arr=[
                'error_code'=>0,
                'msg'=>"获取成功",
                'data'=>$re
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"非法请求",
                'data'=>''
            ];
        }
        echo json_encode($arr);
    }
    /**
    * 修改地址
    *
    * @return void
    */
    public function mailing_addr_usave()
    {
        $data=input("post.");
        $mid=input("mid");
        $re=db("mailing_addr")->where("mid",$mid)->find();
        if($re){
            $res=db("mailing_addr")->where("mid",$mid)->update($data);
            if($res){
                $arr=[
                    'error_code'=>0,
                    'msg'=>"保存成功",
                    'data'=>''
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>"保存失败",
                    'data'=>''
                ];
            }
            
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"非法操作",
                'data'=>''
            ];
        }
        echo json_encode($arr);
    }
    /**
    * 删除地址
    *
    * @return void
    */
    public function mailing_addr_delete()
    {
        $uid=Request::instance()->header("uid");
        $id=input("mid");
        $re=db("mailing_addr")->where(["u_id"=>$uid,"mid"=>$id])->find();
        if($re){
           $del=db("mailing_addr")->where("mid",$re['mid'])->delete();
           $arr=[
            'error_code'=>0,
            'msg'=>"删除成功",
            'data'=>''
        ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"非法操作",
                'data'=>''
            ];
        }
        echo json_encode($arr);
    }

}