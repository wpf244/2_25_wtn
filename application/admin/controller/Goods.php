<?php
namespace app\admin\controller;

use app\admin\model\Goods as GoodsModel;

class Goods extends BaseAdmin{
    private $model = "";
    public function _initialize(){
        parent::_initialize();
        $this->model = new GoodsModel();
    }
    public function type(){
        $list=db('type')->order(['type_sort asc','type_id desc'])->paginate(10);
        $this->assign("list",$list);
        
        $page=$list->render();
        $this->assign("page",$page);
        
        return view('type');
    }
    public function delete_type(){
        $id=input('id');
       
            $del=$this->model->deleteType($id);
            $this->redirect('type');
        
       
    }
    public function save_type(){
        $id=input('id');
        if($id){
            $data['type_name']=input('name');
            if(!is_string(input('image'))){
                $data['type_image']=uploads('image');
            }
            $res=$this->model->updateType($id, $data);
            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }
        }else{
            $data['type_name']=input('name');
            if(!is_string(input('image'))){
                $data['type_image']=uploads('image');
            }
            $re=$this->model->addType($data);
            if($re){
                $this->success("保存成功");
            }else{
                $this->error("保存失败");
            }
        }
    }
    public function modify(){
        $id=input('id');
        $re=db('type')->where("type_id=$id")->find();
        
        echo json_encode($re);
    }
    public function index(){

        $list=db('goods')->alias('a')->where(["g_audi"=>0])->join("type b","a.fid = b.type_id")->order(['g_sort'=> 'asc','gid'=>'desc'])->paginate(20);
        $this->assign("list",$list);
        
        $page=$list->render();
        $this->assign("page",$page);

        
        return view('index');
    }
    public function lister(){
        $sys=db("sys")->where("id",1)->find();
        $sid=input("sid");
        if(empty($sid)){
            $sid=0;
        }
        $map['shopid']=array("eq",$sid);

        if($sid == 0){
            $re['name']=$sys['name'];
        }else{
            $re=db("shop")->field("name")->where("id",$sid)->find();
        }
        $this->assign("re",$re);

        $list=db('goods')->alias('a')->where($map)->where("g_audi",1)->join("type b","a.fid = b.type_id")->order(['g_sort'=> 'asc','gid'=>'desc'])->paginate(20);
        $this->assign("list",$list);
        
        $page=$list->render();
        $this->assign("page",$page);

        
        $arr=array("id"=>0,"name"=>$sys['name']);
        
        $data=db("shop")->field("id,name")->select();
     
        $data[]=$arr;
        foreach($data as $k => $v){
           $data[$k]['id']=$v['id'];
           $data[$k]['text']=$v['name'];
           $data[$k]['parent']="#";
        }
       
        $this->assign("data",json_encode($data));

        
        return view('lister');
    }
    public function add(){
        $res=db('type')->select();
        $this->assign("res",$res);
        
        return view("add");
    }
    public function save(){
        $data=input('post.');
        if(!is_string(input('g_image'))){
            $data['g_image']=uploads('g_image');

            $data['g_images']='/thumb/'.uniqid('',true).'.jpg';
            $data['g_thumb']='/thumb/'.md5(time()).'.jpg';
            $image = \think\Image::open(ROOT_PATH.'/public/'.$data['g_image']);
            $image->thumb(167,78,\think\Image::THUMB_CENTER)->save(ROOT_PATH.'/public/'.$data['g_images']);
            $image->thumb(140,140,\think\Image::THUMB_CENTER)->save(ROOT_PATH.'/public/'.$data['g_thumb']);
        }
       
        if(input('g_status')){
            $data['g_status']=1;
        }
        if(input('g_up')){
            $data['g_up']=1;
        }
        $re=$this->model->addGoods($data);
        if($re){
            $this->success("添加成功");
        }else{
            $this->error("添加失败");
        }
    }
    public function changes(){
        $id=input('id');
        $re=db('goods')->where("gid=$id")->find();
        if($re){
            if($re['g_status'] == 0){
                $res=db('goods')->where("gid=$id")->setField("g_status",1);
            }
            if($re['g_status'] == 1){
                $res=db('goods')->where("gid=$id")->setField("g_status",0);
                
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    public function tong(){
        $id=input('id');
        $re=db('goods')->where("gid=$id")->find();
        if($re){
            if($re['g_audi'] == 0){
                $res=db('goods')->where("gid=$id")->setField("g_audi",1);
            }
            
           
        }
        $this->redirect("index");
    }
    public function changeu(){
        $id=input('id');
        $re=db('goods')->where("gid=$id")->find();
        if($re){
            if($re['g_up'] == 0){
                $res=db('goods')->where("gid=$id")->setField("g_up",1);
            }
            if($re['g_up'] == 1){
                $res=db('goods')->where("gid=$id")->setField("g_up",0);
    
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    public function changeh(){
        $id=input('id');
        $re=db('goods')->where("gid=$id")->find();
        if($re){
            if($re['g_hot'] == 0){
                $res=db('goods')->where("gid=$id")->setField("g_hot",1);
            }
            if($re['g_hot'] == 1){
                $res=db('goods')->where("gid=$id")->setField("g_hot",0);
    
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    public function changea(){
        $id=input('id');
        $re=db('goods')->where("gid=$id")->find();
        if($re){
            if($re['g_te'] == 0){
                $res=db('goods')->where("gid=$id")->setField("g_te",1);
            }
            if($re['g_te'] == 1){
                $res=db('goods')->where("gid=$id")->setField("g_te",0);
    
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    public function changel(){
        $id=input('id');
        $re=db('goods')->where("gid=$id")->find();
        if($re){
            if($re['g_lb'] == 0){
                $res=db('goods')->where("gid=$id")->setField("g_lb",1);
            }
            if($re['g_lb'] == 1){
                $res=db('goods')->where("gid=$id")->setField("g_lb",0);
    
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    public function changess(){
        $id=input('id');
        $re=db('goods')->where("gid=$id")->find();
        if($re){
            if($re['g_search'] == 0){
                $res=db('goods')->where("gid=$id")->setField("g_search",1);
            }
            if($re['g_search'] == 1){
                $res=db('goods')->where("gid=$id")->setField("g_search",0);
    
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    public function sort(){
        $data=input('post.');
        $lb=db('goods');
        foreach ($data as $id => $sort){
            $lb->where(array('gid' => $id ))->setField('g_sort' , $sort);
        }
        $this->redirect('lister');
    }
    public function sorts(){
        $data=input('post.');
        $lb=db('type');
        foreach ($data as $id => $sort){
            $lb->where(array('type_id' => $id ))->setField('type_sort' , $sort);
        }
        $this->redirect('type');
    }
    public function modifys(){
        $id=input('id');
        $re=db('goods')->where("gid=$id")->find();
        $this->assign("re",$re);
        
        $res=db('type')->select();
        $this->assign("res",$res);
        
        return view('modifys');
    }
    public function usave(){
        $id=input('gid');
        $data=input('post.');
        $re=$this->model->findGoods($id);

        if($re){
            if(!is_string(input('g_image'))){
                $data['g_image']=uploads('g_image');
               
                $data['g_images']='/thumb/'.uniqid('',true).'.jpg';
                $data['g_thumb']='/thumb/'.md5(time()).'.jpg';
            //    var_dump($data['g_image']);exit;
                $image = \think\Image::open(ROOT_PATH.'/public/'.$data['g_image']);
                
                $image->thumb(167,78,\think\Image::THUMB_CENTER)->save(ROOT_PATH.'/public/'.$data['g_images']);
                $image->thumb(140,140,\think\Image::THUMB_CENTER)->save(ROOT_PATH.'/public/'.$data['g_thumb']);
            }else{
                $data['g_image']=$re['g_image'];
            }
        
            if(input('g_status')){
                $data['g_status']=1;
            }else{
                $data['g_status']=0;
            }
            if(input('g_up')){
                $data['g_up']=1;
            }else{
                $data['g_up']=0;
            }
            
            $res=$this->model->updateGoods($id,$data);
            if($res){
                $this->success("修改成功",url('lister'));
            }else{
                $this->error("修改失败");
            }
        }else{
            $this->error("参数错误");
        }
        
    }
    public function delete(){
        $id=input('id');
        $del=$this->model->deleteGoods($id);
        $this->redirect('lister');
    }
    public function delete_all(){
        $id=input('id');
        $arr=explode(",", $id);
        $del=$this->model->deleteAll($arr);
        $this->redirect('lister');
    }
    public function spec(){
        $id=input('id');
        $list=db('goods_spec')->alias('a')->where("g_id=$id")->join('goods b','a.g_id=b.gid')->paginate(10);
        $this->assign("list",$list);
        
        $page=$list->render();
        $this->assign("page",$page);
        
        $this->assign("gid",$id);
        
        return view('spec');
    }
    public function img(){
        $id=input('id');
        $list=db('goods_img')->alias('a')->where("gid=$id")->join('goods b','a.g_id=b.gid')->paginate(10);
        $this->assign("list",$list);
        
        $page=$list->render();
        $this->assign("page",$page);
        
        $this->assign("gid",$id);
        
        return view('img');
    }
    public function i_save(){
        $id=input('id');
        if($id){
            $data=input('post.');
            $re=db('goods_img')->where("id=$id")->find();
            if(!is_string(input('image'))){
                $data['image']=uploads("image");
            //     $data['thumb']='uploads/thumb/'.uniqid('',true).'.jpg';
            //    $image = \think\Image::open(request()->file('image'));
            //    $image->thumb(414,414,\think\Image::THUMB_CENTER)->save(ROOT_PATH.'/public/'.$data['thumb']);
            }else{
                $data['image']=$re['image'];
            }
            if(input('i_status')){
                $data['i_status']=1;
            }else{
                $data['i_status']=$re['i_status'];
            }
            $res=$this->model->updateImg($id,$data);
            if($res){
                $this->success("修改成功！");
            }else{
                $this->error("修改失败！");
            }
        }else{
            $data=input('post.');
            if(!is_string(input('image'))){
                $data['image']=uploads("image");
            //     $data['thumb']='uploads/thumb/'.uniqid('',true).'.jpg';
            //    $image = \think\Image::open(request()->file('image'));
            //    $image->thumb(414,414,\think\Image::THUMB_CENTER)->save(ROOT_PATH.'/public/'.$data['thumb']);
            }
            if(input('i_status')){
                $data['i_status']=1;
            }
    
            $re=$this->model->addImg($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            }
        }
         
    }
    public function s_save(){
        $id=input('sid');
        if($id){
            $data=input('post.');
            $re=db('goods_spec')->where("sid=$id")->find();
            if(!is_string(input('s_image'))){
                $data['s_image']=uploads("s_image");
            }else{
                $data['s_image']=$re['s_image'];
            }
            if(input('s_status')){
                $data['s_status']=1;
            }else{
                $data['s_status']=$re['s_status'];
            }
            $res=$this->model->updateSpec($id,$data);
            if($res){
                $this->success("修改成功！");
            }else{
                $this->error("修改失败！");
            }
        }else{
            $data=input('post.');
            if(!is_string(input('s_image'))){
                $data['s_image']=uploads("s_image");
            }
            if(input('s_status')){
                $data['s_status']=1;
            }
            
            $re=$this->model->addSpec($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            }
        }
         
    }
    public function change_s(){
        $id=input('id');
        $re=db('goods_spec')->where("sid=$id")->find();
        if($re){
            if($re['s_status'] == 0){
                $res=db('goods_spec')->where("sid=$id")->setField("s_status",1);
            }
            if($re['s_status'] == 1){
                $res=db('goods_spec')->where("sid=$id")->setField("s_status",0);
    
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    public function change_i(){
        $id=input('id');
        $re=db('goods_img')->where("id=$id")->find();
        if($re){
            if($re['i_status'] == 0){
                $res=db('goods_img')->where("id=$id")->setField("i_status",1);
            }
            if($re['i_status'] == 1){
                $res=db('goods_img')->where("id=$id")->setField("i_status",0);
    
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    public function modify_s(){
        $id=input('id');
        $re=db('goods_spec')->where("sid=$id")->find();
        
        echo json_encode($re);
    }
    public function modify_i(){
        $id=input('id');
        $re=db('goods_img')->where("id=$id")->find();
    
        echo json_encode($re);
    }
    public function delete_s(){
        $id=input('id');
        $re=db('goods_spec')->where("sid=$id")->find();
        if($re){
            $del=db('goods_spec')->where("sid=$id")->delete();
            $this->redirect('lister');
        }else{
            $this->redirect('lister');
        }
    }
    public function delete_i(){
        $id=input('id');
        $re=db('goods_img')->where("id=$id")->find();
        if($re){
            $del=db('goods_img')->where("id=$id")->delete();
            $this->redirect('lister');
        }else{
            $this->redirect('lister');
        }
    }
    public function spec_sort(){
        $data=input('post.');
        $lb=db('goods_spec');
        foreach ($data as $id => $sort){
            $lb->where(array('sid' => $id ))->setField('s_sort' , $sort);
        }
        $this->redirect('lister');
    }
    
    
    
    
    
}