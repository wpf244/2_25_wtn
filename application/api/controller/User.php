<?php
namespace app\api\controller;

use think\Request;

class User extends BaseApi
{
    /**
     * Undocumented function
     *
     * @return 个人资料
     */
    public function index()
    {
        $uid=Request::instance()->header('uid');

        $re=db("user")->field("nickname,image")->where("uid",$uid)->find();
    
        $arr=[
            'error_code'=>0,
            'mag'=>"获取成功",
            'data'=>$re
        ];
          
        echo \json_encode($arr);
    }
    /**
     * Undocumented function
     *
     * @return 帮助中心
     */
    public function help()
    {
        //寄快递
        $hair=db("lb")->field("id,name,desc")->where(["status"=>1,"fid"=>2])->order(["sort asc","id desc"])->select();

        //取快递
        $take=db("lb")->field("id,name,desc")->where(["status"=>1,"fid"=>1])->order(["sort asc","id desc"])->select();

        $arr=[
            'error_code'=>0,
            'mag'=>"获取成功",
            'data'=>[
                'take'=>$take,
                'hair'=>$hair
            ]
        ];
          
        echo \json_encode($arr);

    }
     /**
     * 代言名片
     *
     * @return void
     */
    public function card(){
        $uid = Request::instance()->header('uid');
        $user = db('user')->where('uid', $uid)->find();
        if($user['card'] != ''){
            $url = parent::getUrl().'/'.$user['card'];
            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$url
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'重新获取',
                'data'=>''
            ];
        }
       
        echo \json_encode($arr);
    }

    /**
     * 获取小程序二维码
     *
     * @return void
     */
    public function getqrcode(){
        //接收参数
        $uid = Request::instance()->header('uid');
        $fid = Request::instance()->param('fid', 0);
        $page = Request::instance()->param('page', '');
        //微信token
        $appid = 'wx0bf6a1d285ef4fc8';
        $secret = '32cded6845fe0735fea052ab0e415d1e';
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        $results=json_decode(file_get_contents($url)); 
        //请求二维码的二进制资源
        $post_data='{"fid":"'.$fid.'", "page":"'. $page .'"}';
        $res_url="https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$results->access_token;
        $result=$this->httpRequest($res_url,$post_data,'POST');
        //转码为base64格式并本地保存
        $base64_image ="data:image/jpeg;base64,".base64_encode($result);
        $path = 'uploads/'.uniqid().'.jpg';
        $res = $this->file_put($base64_image, $path);
        //业务处理
        if($res){
            db('user')->where('uid', $uid)->update(['card'=>$path]);
            $url_res=parent::getUrl();
            $arr=[
                'error_code'=>0,
                'data'=>$url_res.'/'.$path,
                'msg'=>'生成成功'
            ];
        }else{
            $arr=[
                'error_code'=>2,
                'data'=>'',
                'msg'=>'生成失败'
            ];
        }
        echo \json_encode($arr);
    }

    /**
     * 图片保存
     *
     * @param [type] $base64_image_content base64格式图片资源
     * @param [type] $new_file 保存的路径，文件夹必须存在
     * @return void
     */
    public function file_put($base64_image_content,$new_file)
    {
        header('Content-type:text/html;charset=utf-8');
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * curl函数网站请求封装函数
     *
     * @param [type] $url 请求地址
     * @param string $data 数据
     * @param string $method 请求方法
     * @return void
     */
    function httpRequest($url, $data='', $method='GET'){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        if($method=='POST')
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data != '')
            {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
        }
     
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    /**
    * 保存收货地址
    *
    * @return void
    */
    public function addr_save()
    {
        $uid=Request::instance()->header('uid');
      
            $data=\input('post.');
            // $re=db("addr")->where("u_id=$uid")->find();
            // if(empty($re)){
            //     $data['default']=1;
            // }
            $data['u_id']=$uid;
            $rea=db('addr')->insert($data);
            $aid = db('addr')->getLastInsID();
            
            if($rea){
                $arr=[
                    'error_code'=>0,
                    'msg'=>'保存成功',
                    'data'=>[
                        'aid'=>$aid
                    ]
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>'保存失败',
                    'data'=>''
                ];
            }
            
       
        echo \json_encode($arr);
    }
    /**
    * 收货地址列表
    *
    * @return void
    */
    public function addr()
    {
        $uid=Request::instance()->header('uid');
        
        $res=\db("addr")->where("u_id=$uid")->order("aid desc")->select();
        if($res){
            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$res
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'暂无数据',
                'data'=>''
            ];
        }
       
        echo \json_encode($arr);
    }
    /**
    * 默认收货地址
    *
    * @return void
    */
    public function addr_default(){
        $uid=Request::instance()->header('uid');
        $re=db('addr')->where("u_id", $uid)->where("default",1)->find();
        if($re){
            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$re
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'暂无数据',
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 修改默认收货地址
    *
    * @return void
    */
    public function change()
    {
        $uid=Request::instance()->header('uid');
     
            $aid=input("aid");
            $re=db("addr")->where("u_id=$uid and aid=$aid")->find();
            $default = db("addr")->where("u_id", $uid)->where('default', 1)->find();
            if($re){
                $res=db("addr")->where("aid=$aid")->setField("default",1);
                if($res){
                    if($default){
                        db("addr")->where("aid", $default['aid'])->setField("default",0);
                    }
                    $arr=[
                        'error_code'=>0,
                        'msg'=>'修改成功',
                        'data'=>''
                    ]; 
                }else{
                    $arr=[
                        'error_code'=>1,
                        'msg'=>'修改失败',
                        'data'=>''
                    ]; 
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>'非法操作',
                    'data'=>''
                ]; 
            }
      
        echo \json_encode($arr);
    }
    /**
    * 收货地址详情
    *
    * @return void
    */
    public function addr_detail()
    {
        $aid=\input('aid');
        $re=db('addr')->where("aid=$aid")->find();
        if($re){
            $arr=[
                'error_code'=>0,
                'msg'=>"获取成功",
                'data'=>$re
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>"获取失败",
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 保存修改收货地址
    *
    * @return void
    */
    public function addr_usave()
    {
        $aid=\input('aid');
        $re=db("addr")->where("aid=$aid")->find();
        if($re){
            $data=\input('post.');
            $res=db("addr")->where("aid=$aid")->update($data);
            if($res){
                $arr=[
                    'error_code'=>0,
                    'msg'=>'修改成功',
                    'data'=>''
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>'修改失败',
                    'data'=>''
                ];
            }
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'非法操作',
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 删除收货地址
    *
    * @return void
    */
    public function addr_detele()
    {
        $aid=\input('aid');
        $re=\db('addr')->where("aid=$aid")->find();
        if($re){
           $del=\db('addr')->where("aid=$aid")->delete();
           if($del){
               $arr=[
                   'error_code'=>0,
                   'msg'=>'删除成功',
                   'data'=>''
               ];
           }else{
               $arr=[
                   'error_code'=>2,
                   'msg'=>'删除失败',
                   'data'=>''
               ];
           }
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'收货地址不存在',
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 商品收藏
    *
    * @return void
    */
    public function my_collect()
    {
        $uid=Request::instance()->header('uid');
        
        $res=db("collect")->alias("a")->where("u_id=$uid")->join("goods b","a.g_id=b.gid")->select();
        if($res){
            $url=parent::getUrl();
            $arrs=array();
            foreach ($res as $k => $v){
                $arrs[$k]['gid']=$v['gid'];
                $arrs[$k]['g_name']=$v['g_name'];
                $arrs[$k]['g_xprice']=$v['g_xprice']; 
                $arrs[$k]['g_image']=$url.$v['g_thumb'];  
            }
            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$arrs
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'没有数据',
                'data'=>''
            ];
        }
       
        echo \json_encode($arr);
    }
    /**
    * 店铺收藏
    *
    * @return void
    */
    public function my_shop_collect()
    {
        $uid=Request::instance()->header("uid");
        $res=db("shop_collect")->where(["uid"=>$uid])->select();
        if($res){
            $url=parent::getUrl();
            $arrs=array();
            foreach($res as $k => $v){
                if($v['shopid'] == 0){
                    $re=db("sys")->field("name,pclogo as logo")->where("id",1)->find();
                }else{
                    $re=db("shop")->field("name,logo")->where("id",$v['shopid'])->find();
                }
                $arrs[$k]['shopid']=$v['shopid'];
                $arrs[$k]['name']=$re['name'];
                $arrs[$k]['logo']=$url.$re['logo'];
            }
            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$arrs
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'没有数据',
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 我的订单
    *
    * @return void
    */
    public function my_dd()
    {
        $uid=Request::instance()->header('uid');
        
        $status=input("status");

        if($status || $status === "0"){
 
            $res=db("car_dd")->where("uid=$uid and status=$status and gid=0")->order("did desc")->select();
        }else{

            $res=db("car_dd")->where("uid=$uid and gid=0 and status >= 0")->order("did desc")->select();
        }
        
       if($res){
        
            $url=parent::getUrl();
            $arrs=array();
            foreach ($res as $k => $v){
                $arrs[$k]['did']=$v['did'];
                $arrs[$k]['uid']=$v['uid'];
                $arrs[$k]['shopid']=$v['shopid'];
                $arrs[$k]['status']=$v['status'];
                $shopid=$v['shopid'];
                if($shopid == 0){
                    $arrs[$k]['shopname']=db("sys")->field("name")->where("id",1)->find()['name'];
                }else{
                    $arrs[$k]['shopname']=db("shop")->field("name")->where("id",$shopid)->find()['name'];
                }
                    
                $pay=$v['pay'];
                $pays=\explode(",", $pay);
                $arrss=array();
                foreach ($pays as $kk => $vv){
                    
                    $dd=db("car_dd")->where("code='$vv'")->find();
                    $arrss[$kk]['g_image']=$url.$dd['g_image'];
                //    $arrss[$kk]['did']=$dd['did'];
                    $arrss[$kk]['g_name']=$dd['g_name'];
                    $arrss[$kk]['g_xprice']=$dd['price'];
                    $arrss[$kk]['num']=$dd['num'];
                    $arrss[$kk]['s_name']=$dd['s_name'];
                    $arrss[$kk]['gid']=$dd['gid'];
                    $arrss[$kk]['x_total']=($dd['num']*$dd['price']);
                
                }
            //  var_dump($arrss);
                $arrs[$k]['goods']=$arrss;
            }
            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$arrs
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'没有数据',
                'data'=>''
            ];
        }
      
        echo \json_encode($arr);
    }
    /**
    * 订单详情
    *
    * @return void
    */
    public function detail_dd()
    {
        $did=\input('did');
        $re=db("car_dd")->where("did=$did")->find();
        if($re){
            $arrs=array();
            $url=parent::getUrl();
            $arrs['did']=$re['did'];
            $arrs['code']=$re['code'];
            $arrs['status']=$re['status'];
            $arrs['freight']=$re['freight'];
            $arrs['content']=$re['content'];
            $arrs['money']=$re['zprice'];
            $arrs['time']=intval($re['time']);
            $arrs['fu_time']=intval($re['fu_time']);
            $arrs['fa_time']=intval($re['fa_time']);
            $arrs['end_time']=intval($re['end_time']);
            $shopid=$re['shopid'];
            if($shopid == 0){
                $arrs['shopname']=db("sys")->field("name")->where("id",1)->find()['name'];
            }else{
                $arrs['shopname']=db("shop")->field("name")->where("id",$shopid)->find()['name'];
            }
            $arrs['shopid']=$shopid;
          
            $aid=$re['a_id'];
            $addr=db("addr")->where("aid=$aid")->find();
            $arrs['addr']=$addr;
            $pay=$re['pay'];
            $pays=\explode(",", $pay);
            $res=db("car_dd")->where(array('code'=>array('in',$pays)))->select();
            $arrss=array();
            foreach ($res as $k => $v){
                $arrss[$k]['g_image']=$url.$v['g_image'];
                $arrss[$k]['g_name']=$v['g_name'];
                $arrss[$k]['s_name']=$v['s_name'];
                $arrss[$k]['g_xprice']=$v['price'];
                $arrss[$k]['num']=$v['num'];
            }
            $arrs['goods']=$arrss;
           
            
            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$arrs
            ];
            
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'没有此订单',
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 订单取消原因
    *
    * @return void
    */
    public function reason()
    {
        $res=db("lb")->field("name")->where(["fid"=>6,"status"=>1])->order(["sort asc","id asc"])->select();
        if($res){
            $arr=[
                'error_code'=>1,
                'msg'=>'获取成功',
                'data'=>$res
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'暂无数据',
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 取消订单
    *
    * @return void
    */
    public function delete_dd()
    {
        $uid=Request::instance()->header('uid');
  
            $did=\input('did');
            $re=\db('car_dd')->where("uid=$uid and did=$did")->find();
            $data['status']=-1;
            $data['reason']=\input("reason");
            if($re){
                $del=db('car_dd')->where("uid=$uid and did=$did")->update($data);
                $pay=$re['pay'];
                $pays=\explode(",", $pay);
                
                $res=db('car_dd')->where(array('code'=>array('in',$pays)))->select();
                if($res){
                    $dels=db('car_dd')->where(array('code'=>array('in',$pays)))->update($data);
                }
                if($del){
                    $arr=[
                        'error_code'=>0,
                        'msg'=>'删除成功',
                        'data'=>''
                    ];
                }else{
                    $arr=[
                        'error_code'=>1,
                        'msg'=>'删除失败',
                        'data'=>''
                    ];
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>'非法操作',
                    'data'=>''
                ];
            }
    
        echo \json_encode($arr);
    }
    /**
    * 申请退货
    *
    * @return void
    */
    public function retreat()
    {
        $did=\input('did');
        $re=db("car_dd")->where("did=$did")->find();
        if($re){
            $arrs=array();
            $url=parent::getUrl();
            $arrs['did']=$re['did'];
            $arrs['money']=$re['zprice'];
       
            $pay=$re['pay'];
            $pays=\explode(",", $pay);
            $res=db("car_dd")->where(array('code'=>array('in',$pays)))->select();
            $arrss=array();
            foreach ($res as $k => $v){
                $arrss[$k]['g_image']=$url.$v['g_image'];
                $arrss[$k]['g_name']=$v['g_name'];
                $arrss[$k]['s_name']=$v['s_name'];
                $arrss[$k]['g_xprice']=$v['price'];
                $arrss[$k]['num']=$v['num'];
            }
            $arrs['goods']=$arrss;
           
            
            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$arrs
            ];
            
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'没有此订单',
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 退货订单
    *
    * @return void
    */
    public function tui()
    {
        $uid=Request::instance()->header('uid');
        
            $did=input('did');
            $re=db("car_dd")->where("uid=$uid and did=$did")->find();
            if($re){
                if($re['status'] != 0){
                    $arr['tui_content']=input("content");
                    $arr['reason']=input("reason");
                    $arr['tui_time']=time();
                    $arr['status']=5;
                    $pay=$re['pay'];
                    $pays=explode(",",$pay);
                    foreach($pays as $v){
                        $red=db("car_dd")->where("code='$v'")->find();
                        if($red){
                            db("car_dd")->where("code='$v'")->update($arr);
                        }
                    }
                    $res=db("car_dd")->where("uid=$uid and did=$did")->update($arr);
                    if($res){
                        $arr=[
                            'error_code'=>0,
                            'msg'=>'申请提交成功',
                            'data'=>''
                        ];
                    }else{
                        $arr=[
                            'error_code'=>1,
                            'msg'=>'申请提交失败',
                            'data'=>''
                        ];
                    }
                }else{
                    $arr=[
                        'error_code'=>2,
                        'msg'=>'非法操作',
                        'data'=>''
                    ];  
                }
            }else{
                $arr=[
                    'error_code'=>3,
                    'msg'=>'没有此订单',
                    'data'=>''
                ]; 
            }

        echo json_encode($arr);
    }
    /**
    * 确认收货
    *
    * @return void
    */
    public function take_goods()
    {
        $uid=Request::instance()->header('uid');
        
            $did=\input('did');
            $re=\db('car_dd')->where("uid=$uid and did=$did")->find();
            if($re){
                if($re['status'] == 2){
                   $res=db('car_dd')->where("uid=$uid and did=$did")->setField("status",3);
                   $pay=$re['pay'];
                   $pays=\explode(",", $pay);
                   
                   $res=db('car_dd')->where(array('code'=>array('in',$pays)))->select();
                   if($res){
                       $dels=db('car_dd')->where(array('code'=>array('in',$pays)))->setField("status",3);
                   }
                    if($res){
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
                    $arr=[
                        'error_code'=>2,
                        'msg'=>'非法操作',
                        'data'=>''
                    ];
                }
                
            }else{
                $arr=[
                    'error_code'=>2,
                    'data'=>'非法操作'
                ];
            }
        
        echo \json_encode($arr);
    }
    /**
    * 商品评价
    *
    * @return void
    */
    public function goods_assess()
    {
        $did=\input('did');
        $re=db("car_dd")->where("did=$did")->find();
        if($re){
            $url=parent::getUrl();
            $arrs=array();
            
            $pay=$re['pay'];
            $pays=\explode(",", $pay);
            $res=db("car_dd")->where(array('code'=>array('in',$pays)))->select();
            foreach ($res as $k => $v){
                $arrs[$k]['gid']=$v['gid'];
                $arrs[$k]['g_image']=$url.$v['g_image'];
            }
            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>[
                    'did'=>$did,
                    'goods'=>$arrs
                ]
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'没有此订单',
                'data'=>''
            ];
        }
        echo \json_encode($arr);
    }
    /**
    * 保存评价
    *
    * @return void
    */
    public function save_assess()
    {
        $uid=Request::instance()->header('uid');
        
            $did=\input('did');
            $re=db("car_dd")->where("did=$did")->find();
            if($re){
                if($re['status'] == 3){
                    $res=db("car_dd")->where("did=$did")->setField("status",4);
                    $pay=$re['pay'];
                    $pays=\explode(",", $pay);
                    $res=db("car_dd")->where(array('code'=>array('in',$pays)))->select();
                    if($res){
                        $ress=db("car_dd")->where(array('code'=>array('in',$pays)))->setField("status",4);
                    }
                    $datas=\input('post.');
                    $assess=$datas['assess'];
                    foreach ($assess as $v){
                        $data['u_id']=$uid;
                        $data['g_id']=$v['gid'];
                        $data['number']=$v['num'];
                        $data['content']=$v['content'];
                        $data['addtime']=\time();
                        
                        db("assess")->insert($data);
                    }
                    $arr=[
                        'error_code'=>0,
                        'msg'=>'发布成功',
                        'data'=>''
                    ];
                }else{
                    $arr=[
                        'error_code'=>1,
                        'msg'=>'非法操作',
                        'data'=>''
                    ];
                }
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>'非法操作',
                    'data'=>''
                ];
            }
       
        echo \json_encode($arr);
    }
    /**
    * 反馈与建议
    *
    * @return void
    */
    public function advise()
    {
        $uid=Request::instance()->header("uid");
        $data['u_id']=$uid;
        $data['content']=input("content");
        $re=db("advise")->insert($data);
        if($re){
            $arr=[
                'error_code'=>0,
                'msg'=>'发布成功',
                'data'=>''
            ];
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'发布失败',
                'data'=>''
            ];
        }
        echo \json_encode($arr);

    }
    /**
    * 获取验证码
    *
    * @return void
    */
    public function getcode(){
        $phone=input('phone');
        $re=db('user')->where("phone=$phone")->find();
        if($re){
            $arr=[
                'error_code'=>1,
                'msg'=>'此手机号已绑定',
                'data'=>""
            ];
        }else{
            $code =mt_rand(100000,999999);       
            $data['phone']=$phone;
            $data['code']=$code;
            $data['time']=time();
            $re=\db("code")->where("phone='$phone'")->find();
            if($re){
                $del=db("code")->where("phone='$phone'")->delete();
            }
            $rea=db("code")->insert($data);
            Post($phone,$code);
            if($rea){
                $arr=[
                    'error_code'=>0,
                    'msg'=>'发送成功',
                    'data'=>''
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>'发送失败',
                    'data'=>''
                ];
            }
           
        }
        echo json_encode($arr);
    }
    /**
    * 保存
    *
    * @return void
    */
    public function save_phone()
    {
        $uid=Request::instance()->header("uid");
        $phone=input("phone");
        $code=input("code");
        $re=db("code")->where(['phone'=>$phone,'code'=>$code])->find();
        if($re){
            $time=$re['time'];
            $times=time();
            $c_time=($times-$time);
            if($c_time < 300){
                 db("code")->where("id",$re['id'])->delete();
                $data['phone']=$phone;
                $res=db("user")->where("uid",$uid)->update($data);
                if($res){
                    $arr=[
                        'error_code'=>0,
                        'msg'=>'绑定成功',
                        'data'=>''
                    ]; 
                }else{
                    $arr=[
                        'error_code'=>3,
                        'msg'=>'绑定失败',
                        'data'=>''
                    ]; 
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>'验证码已失效',
                    'data'=>''
                ]; 
            }
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'验证码错误',
                'data'=>''
            ];
        }
        echo json_encode($arr);
    }






























}