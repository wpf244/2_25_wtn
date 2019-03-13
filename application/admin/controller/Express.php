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
}