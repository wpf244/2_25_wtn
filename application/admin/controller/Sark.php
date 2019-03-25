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
        $list=db("sark")->alias("a")->field("a.*,b.firm_name")->join("sark_firm b","a.fid=b.id","left")->order("id desc")->paginate(20);
        $this->assign("list",$list);
        $page=$list->render();
        $this->assign("page",$page);
        return $this->fetch();
    }
    public function adds()
    {
       $res=db("sark_firm")->select();
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
           $phone=input("phone");
           if($phone){
             $phones=\explode("@",$phone);
             foreach($phones as $v){
                 $datas['code']=$code;
                 $datas['phone']=$v;
                 db("sark_phone")->insert($datas);
             }
           }
           
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
    
        $res=db("sark_firm")->select();
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
                $res=db("sark_phone")->where("code",$code)->select();
                if($res){
                    db("sark_phone")->where("code",$code)->delete();
                }
                $phone=input("phone");
                if($phone){
                    $phones=\explode("@",$phone);
                    foreach($phones as $v){
                        $datas['code']=$code;
                        $datas['phone']=$v;
                        db("sark_phone")->insert($datas);
                    }
                }
               
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
    public function free()
    {
        $re=db("free")->where("id",1)->find();
        $this->assign("re",$re);
        return $this->fetch();
    }
    public function savef()
    {
        $data=input("post.");
        $re=db("free")->where("id",1)->update($data);
        if($re){
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }
    }
    public function money()
    {
        $re=db("free")->where("id",2)->find();
        $this->assign("re",$re);
        return $this->fetch();
    }
    public function savem()
    {
        $data=input("post.");
        $re=db("free")->where("id",2)->update($data);
        if($re){
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }
    }
    public function sales()
    {
        $re=db("free")->where("id",3)->find();
        $this->assign("re",$re);
        return $this->fetch();
    }
    public function savel()
    {
        $data=input("post.");
        $re=db("free")->where("id",3)->update($data);
        if($re){
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }
    }
    public function firm()
    {
        $list=db("sark_firm")->order("id desc")->paginate(10);
        $this->assign("list",$list);
        $page=$list->render();
        $this->assign("page",$page);
        return $this->fetch();
    }
    public function addf()
    {
        return $this->fetch();
    }
    public function savems()
    {
        $data=input("post.");
        $re=db("sark_firm")->insert($data);
        if($re){
            $this->success("添加成功",url('firm'));
        }else{
            $this->error("添加失败",url('firm'));
        }
    }
    public function modifyf()
    {
        $id=input("id");
        $re=db("sark_firm")->where("id",$id)->find();
        $this->assign("re",$re);
        return $this->fetch();
    }
    public function usavems()
    {
        $data=input("post.");
        $a_id=input("id");
        
        $re=db("sark_firm")->where("id",$a_id)->find();
        if($re){

            $res=db("sark_firm")->where("id",$a_id)->update($data);
            if($res){
                $this->success("修改成功",url("firm"));
            }else{
                $this->error("修改失败",url("firm"));
            }
        }else{
            $this->error("非法操作",url("firm"));
        }
    }
    public function deletef()
    {
        $id=input("id");
        $re=db("sark_firm")->where("id",$id)->find();
        if($re){
            $del=db("sark_firm")->where("id",$id)->delete();
        }
        $this->redirect("firm");
    }

}