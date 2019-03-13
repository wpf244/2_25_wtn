<?php
namespace app\admin\controller;

class Sark extends BaseAdmin
{
    public function addr()
    {
        $list=db("sark_addr")->order("a_id asc")->paginate(20);
        $this->assign("list",$list);
        $page=$list->render();
        $this->assign("page",$page);
        return $this->fetch();
    }
    public function add()
    {
        return $this->fetch();
    }
    public function saves()
    {
        $data=input('post.');  
        $data['a_time']=date("Y-m-d H:i:s");
        $re=db("sark_addr")->insert($data);
        if($re){
            $this->success("添加成功",url('addr'));
        }else{
            $this->error("添加失败",url('addr'));
        }
    }
    public function modify()
    {
        $id=\input("id");
        $re=db("sark_addr")->where("a_id",$id)->find();
        $this->assign("re",$re);
        return $this->fetch();
    }
    public function usaves()
    {
        $a_id=input("a_id");
        $data['a_name']=input("a_name");
        $re=db("sark_addr")->where("a_id",$a_id)->find();
        if($re){

            $res=db("sark_addr")->where("a_id",$a_id)->update($data);
            if($res){
                $this->success("修改成功",url("addr"));
            }else{
                $this->error("修改失败",url("addr"));
            }
        }else{
            $this->error("非法操作",url("addr"));
        }
    }
    public function delete()
    {
        $id=input("id");
        $re=db("sark_addr")->where("a_id",$id)->find();
        if($re){
            $del=db("sark_addr")->where("a_id",$id)->delete();
            

        }
        $this->redirect("addr");
    }
    public function lister()
    {
        $list=db("sark")->alias("a")->join("sark_addr b","a.aid=b.a_id")->order("id desc")->paginate(20);
        $this->assign("list",$list);
        $page=$list->render();
        $this->assign("page",$page);
        return $this->fetch();
    }
    public function adds()
    {
        $res=db("sark_addr")->select();
        $this->assign("res",$res);
        return $this->fetch();
    }
    public function save()
    {
       $data=input("post.");
       $code=input("code");
       $data['time']=date("Y-m-d H:i:s");
       $re=db("sark")->where("code",$code)->find();
       if($re){
           $this->error("此编号已存在",url('lister'));exit;
       }else{
           $rea=db("sark")->insert($data);
           if($rea){
               $this->success("添加成功",url("lister"));
           }else{
               $this->error("添加失败",url('lister'));
           }
       }
    }
    public function deletes()
    {
        $id=input("id");
        $re=db("sark")->where("id",$id)->find();
        if($re){
            $del=db("sark")->where("id",$id)->delete();
        }
        $this->redirect("lister");
    }
    public function modifys()
    {
        $res=db("sark_addr")->select();
        $this->assign("res",$res);

        $id=\input("id");
        $re=db("sark")->where("id",$id)->find();
        $this->assign("re",$re);
        
        return $this->fetch();
    }
    public function usave()
    {
        $data=input("post.");
        $code=input("code");
        $id=input("id");
        $re=db("sark")->where("id",$id)->find();
        if($re){
            $re=db("sark")->where(["code"=>$code,"id"=>["neq",$id]])->find();
            if($re){
                $this->error("此编号已存在",url('lister'));exit;
            }else{
                $rea=db("sark")->where("id",$id)->update($data);
                if($rea){
                    $this->success("修改成功",url("lister"));
                }else{
                    $this->error("修改失败",url('lister'));
                }
            }
        }else{
            $this->error("非法操作",url("lister"));
        }
       
    }

}