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
}