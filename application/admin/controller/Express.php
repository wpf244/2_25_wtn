<?php
namespace app\admin\controller;

class Express extends BaseAdmin
{
    public function lister()
    {
        $list=db("express")->order("ex_id desc")->select();
        $this->assign("list",$list);
        return $this->fetch();
    }
    public function add()
    {
        return $this->fetch();
    }
    public function save()
    {
        $data=input('post.');  
        if(input('ex_status')){
            $data['ex_status']=1;
        } 
        $data['ex_time']=date("Y-m-d H:i:s");
        $re=db("express")->insert($data);
        if($re){
            $this->success("添加成功",url('lister'));
        }else{
            $this->error("添加失败",url('lister'));
        }
    }
    public function delete()
    {
        $id=input("id");
        $re=db("express")->where("ex_id",$id)->find();
        if($re){
            $del=db("express")->where("ex_id",$id)->delete();
        }
        $this->redirect("lister");
    }
    public function modifys()
    {
        $id=input("id");
        $re=db("express")->where("ex_id",$id)->find();
        $this->assign("re",$re);
        return $this->fetch();
    }
    public function usave()
    {
        $id=input("ex_id");
        $data=input("post.");
        if(input('ex_status')){
            $data['ex_status']=1;
        }else{
            $data['ex_status']=0;
        }
        $re=db("express")->where("ex_id",$id)->find();
        if($re){
            $res=db("express")->where("ex_id",$id)->update($data);
            if($res){
                $this->success("修改成功",url("lister"));
            }else{
                $this->error("修改失败",url("lister")); 
            }
        }else{
            $this->error("参数错误",url("lister"));
        }
    }
    public function index()
    {

        $list=db("courier")->alias("a")->join("sark_addr b",'a.aid=b.a_id')->join("express c","a.eid=c.ex_id")->order("cid desc")->paginate(20);
        $this->assign("list",$list);

        $page=$list->render();
        $this->assign("page",$page);

        return $this->fetch();
    }
    public function adds()
    {
        //公司列表
        $express=db("express")->where("ex_status",1)->select();
        $this->assign("express",$express);

        $res=db("sark_addr")->select();
        $this->assign("res",$res);
        
        return $this->fetch();
    }
    public function saves()
    {
        $data=input("post.");
        $phone=input("phone");
        $re=db("courier")->where("phone",$phone)->find();
        if($re){
            $this->error("此手机号已绑定",url("index"));exit;
        }else{
            $data['time']=date("Y-m-d H:i:s");
            $rea=db("courier")->insert($data);
            if($rea){
                $this->success("添加成功",url('index'));
            }else{
                $this->error("添加失败",url("index"));
            }
        }
    }
    public function modify()
    {
        //公司列表
        $express=db("express")->where("ex_status",1)->select();
        $this->assign("express",$express);

        $res=db("sark_addr")->select();
        $this->assign("res",$res);

        $id=input("id");
        $re=db("courier")->where("cid",$id)->find();
        $this->assign("re",$re);

        return $this->fetch();
    }
    public function usaves()
    {
        $data=input("post.");
        $phone=input("phone");
        $cid=input("cid");
        $re=db("courier")->where("cid",$cid)->find();
        if($re){
            
            $res=db("courier")->where(["phone"=>$phone,"cid"=>['neq',$cid]])->find();
            if($res){
                $this->error("此手机号已绑定",url("index"));exit;
            }else{
               
                $rea=db("courier")->where("cid",$cid)->update($data);
                if($rea){
                    $this->success("添加成功",url('index'));
                }else{
                    $this->error("添加失败",url("index"));
                }
            }
        }else{
           
            $this->error("非法操作",url("index"));
        }
    }
    public function deletes()
    {
        $id=input("id");
        $re=db("courier")->where("cid",$id)->find();
        if($re){
            $del=db("courier")->where("cid",$id)->delete();
        }
        $this->redirect("index");
    }

}