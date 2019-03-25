<?php
namespace app\admin\controller;

class Shop extends BaseAdmin
{
    public function lister()
    {
        $list=db("shop")->where("apply",1)->order("id desc")->paginate(10);
        $page=$list->render();
        $this->assign("list",$list);
        $this->assign("page",$page);
        return $this->fetch();
    }
    public function add()
    {
        return $this->fetch();
    }
    public function check_username()
    {
        $username=input("username");
        $re=db("shop")->where("username",$username)->find();
        if($re){
            echo '0';
        }else{
            echo '1';
        }
    }
    public function save()
    {
        $data=input('post.');
        if(!is_string(input('logo'))){
            $data['logo']=uploads('logo');
        }
        if(!is_string(input('image'))){
            $data['image']=uploads('image');
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
       
        $id=input("id");
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
        }else{
            $data['logo']=$re['logo'];
        }
        if(!is_string(input('image'))){
            $data['image']=uploads('image');
        }else{
            $data['image']=$re['image'];
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
            $this->success("修改成功",url('lister'));
        }else{
            $this->error("修改失败",url('lister'));
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
    public function deletes()
    {
        $id=input("id");
        $re=db("shop")->where("id",$id)->find();
        if($re){
            $del=db("shop")->where("id",$id)->delete();
         

        }
        $this->redirect("apply");
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
    public function apply()
    {
        $list=db("shop")->where("apply",0)->paginate(20);
        $this->assign("list",$list);
        $page=$list->render();
        $this->assign("page",$page);
        return $this->fetch();
    }
    public function apply_save()
    {
        $id=input("id");
        $re=db("shop")->where("id",$id)->find();
        $this->assign("re",$re);
        return $this->fetch();
    }
    public function saves()
    {
        $data=input('post.');
        $id=input("id");
        $re=db("shop")->where("id",$id)->find();
        if($re){
            if(!is_string(input('logo'))){
                $data['logo']=uploads('logo');
            }
            if(!is_string(input('image'))){
                $data['image']=uploads('image');
            }
           
            if(input('status')){
                $data['status']=1;
            }
            if(input('goods_status')){
                $data['goods_status']=1;
            }
            $data['apply']=1;
            $data['addtime']=date("Y-m-d H:i:s");
            $re=db("shop")->where("id",$id)->update($data);
            if($re){
                $this->success("审核通过成功",url('apply'));
            }else{
                $this->error("审核通过失败",url('apply'));
            }
        }else{
            $this->error("非法操作",url('apply'));
        }
        
    }
}