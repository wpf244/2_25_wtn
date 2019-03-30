<?php
namespace app\api\controller;

class Index extends BaseApi
{
    public function index()
    {
        $url=parent::getUrl();
        //banner
        $banner=db("lb")->field("id,url,image")->where(["fid"=>3,"status"=>1])->order(["sort asc","id desc"])->select();
        foreach($banner as $k => $v){
            $banner[$k]['image']=$url.$v['image'];
        }

        //海报
        $poster=db("lb")->field("id,url,image")->where("fid",4)->find();
        $poster['image']=$url.$poster['image'];

        //精选爆款
        $goods=db("goods")->field("gid,g_image")->where(["g_up"=>1,"g_status"=>1,"g_audi"=>1])->order(["g_sort asc","gid desc"])->limit(0,4)->select();
        foreach($goods as $kk => $vv){
            $goods[$kk]['g_images']=$url.$vv['g_image'];
        }
        //商城公告
        $notice=db("lb")->field("name")->where(["fid"=>7,"status"=>1])->select();


        $arr=[
            'error_code'=>0,
            'msg'=>"获取成功",
            'data'=>[
                'banner'=>$banner,
                'poster'=>$poster,
                'goods'=>$goods,
                'notice'=>$notice
            ]
        ];
          
        echo \json_encode($arr);

    }
    /**
     * 更多优惠
     *
     * @return void
     */
    public function more()
    {
        $url=parent::getUrl();
        //banner
        $banner=db("lb")->field("id,url,image")->where("fid",5)->find();

        $banner['image']=$url.$banner['image'];

        //商品
        $goods=db("goods")->field("gid,g_image,g_xprice,g_name")->where(["g_up"=>1,"g_status"=>1,"g_audi"=>1])->order(["g_sort asc","gid desc"])->select();
        foreach($goods as $kk => $vv){
            $goods[$kk]['g_thumb']=$url.$vv['g_image'];
        }
        $arr=[
            'error_code'=>0,
            'msg'=>"获取成功",
            'data'=>[
                'banner'=>$banner,
                'goods'=>$goods
            ]
        ];
          
        echo \json_encode($arr);
    }
    /**
     * 发现
     * 
     */
    public function kinds()
    {
        $url=parent::getUrl();
        $res=db("type")->field("type_id,type_name")->order(["type_sort asc","type_id desc"])->select();
        foreach($res as $k => $v){
            $res[$k]['goods']=db("goods")->field("gid,g_name,g_image")->where(["g_up"=>1,"g_audi"=>1,"fid"=>$v['type_id']])->order(["g_sort asc","gid desc"])->select();
            foreach ($res[$k]['goods'] as $kk => $vv) {
                $res[$k]['goods'][$kk]['g_image']=$url.$vv['g_image'];
            }

        }
        $arr=[
            'error_code'=>0,
            'msg'=>"获取成功",
            'data'=>$res
        ];
          
        echo \json_encode($arr);
    }
    /**
     * 
     * 搜索
     */
    public function search()
    {
        $url=parent::getUrl();
        $keywords=input("keywords");
        $sort=input("sort");
        if($sort){
            //价格升序
             if($sort == 1){
                $order=["g_xprice desc","gid desc"];
             }
             //价格降序
             if($sort == 2){
                $order=["g_xprice asc","gid desc"];
             }
             //销量升序
             if($sort == 3){
                $order=["g_sales desc","gid desc"];
             }
             //销量降序
             if($sort == 4){
                $order=["g_sales asc","gid desc"];
             }

        }else{
            $order=["g_sort asc","gid desc"];
        }
        
        $goods=db("goods")->field("gid,g_name,g_xprice,desc,tag,g_sales,g_image,shopid")->where(["g_up"=>1,"g_audi"=>1])->where("g_name","like","%".$keywords."%")->order($order)->select();
        foreach($goods as $k => $v){
            $goods[$k]['g_thumb']=$url.$v['g_image'];
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
}