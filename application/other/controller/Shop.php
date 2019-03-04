<?php
namespace app\other\controller;

class Shop extends BaseAdmin
{
    public function lister()
    {
        $shopid=session("uid");
        $list=db("hot")->where("shopid",$shopid)->order("id desc")->paginate(10);
        $page=$list->render();
        $this->assign("list",$list);
        $this->assign("page",$page);
        return $this->fetch();
    }
    public function saves(){
        if($this->request->isAjax()){
            $id=input("id");
            if($id){
                $data['name']=input('name');
                $res=db("hot")->where("id",$id)->update($data);
                if($res){
                    $this->success("修改成功！",url('lister'));
                }else{
                    $this->error("修改失败！",url('lister'));
                }
            }else{
                $data['name']=input('name');
                $re=db("hot")->insert($data);
                if($re){
                    $this->success("添加成功！",url('lister'));
                }else{
                    $this->error("添加失败！",url('lister'));
                } 
            }
            
        }else{
            $this->success("非法提交",url('lister'));
        }
    }
    public function save()
    {
        $data=input('post.');
        if(!is_string(input('logo'))){
            $data['logo']=uploads('logo');

            // $data['g_images']='/uploads/thumb/'.uniqid('',true).'.jpg';
            // $image = \think\Image::open(request()->file('g_image'));
            // $image->thumb(104,104,\think\Image::THUMB_CENTER)->save(ROOT_PATH.'/public/'.$data['g_images']);
        }
       
        if(input('status')){
            $data['status']=1;
        }
        if(input('goods_status')){
            $data['goods_status']=1;
        }
        $data['addtime']=date("Y-m-d H:i:s");
        $re=db("shop")->insert($data);
        if($re){
            $this->success("添加成功",url('lister'));
        }else{
            $this->error("添加失败",url('lister'));
        }
    }
    public function modifys(){
       
        $id=session("uid");
        $re=db("shop")->where("id",$id)->find();
        $this->assign("re",$re);

        return $this->fetch();
    }
    public function usave()
    {
        $id=input("id");
        $re=db("shop")->where("id",$id)->find();
        $data=input('post.');
        if(!is_string(input('logo'))){
            $data['logo']=uploads('logo');

            // $data['g_images']='/uploads/thumb/'.uniqid('',true).'.jpg';
            // $image = \think\Image::open(request()->file('g_image'));
            // $image->thumb(104,104,\think\Image::THUMB_CENTER)->save(ROOT_PATH.'/public/'.$data['g_images']);
        }else{
            $data['logo']=$re['logo'];
        }
       
        if(input('status')){
            $data['status']=1;
        }else{
            $data['status']=0;
        }
        if(input('goods_status')){
            $data['goods_status']=1;
        }else{
            $data['goods_status']=0;
        }
       
        $re=db("shop")->where("id",$id)->update($data);
        if($re){
            $this->success("修改成功",url('modifys'));
        }else{
            $this->error("修改失败",url('modifys'));
        }
    }
    public function delete()
    {
        $id=input("id");
        $re=db("shop")->where("id",$id)->find();
        if($re){
            $del=db("shop")->where("id",$id)->delete();
            $res=db("goods")->where("shopid",$id)->select();
            if($res){
                db("goods")->where("shopid",$id)->delete();
            }

        }
        $this->redirect("lister");
    }
    public function changes()
    {
        $id=input("id");
        $re=db("shop")->where("id",$id)->find();
        if($re){
            if($re['status'] == 0){
                db("shop")->where("id",$id)->setField("status",1);
                $res=db("goods")->where("shopid",$id)->select();
                if($res){
                    db("goods")->where("shopid",$id)->setField("g_up",1);
                }
            }else{
                db("shop")->where("id",$id)->setField("status",0);
                $res=db("goods")->where("shopid",$id)->select();
                if($res){
                    db("goods")->where("shopid",$id)->setField("g_up",0);
                }
            }

        }
    }
}