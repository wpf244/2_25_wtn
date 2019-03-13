<?php
namespace app\index\controller;

use think\Controller;


class Index extends Controller
{
    public function index()
    {
   
        // include_once 'simple/simple_html_dom.php';
        // //获取html数据转化为对象
        // $html = file_get_html('http://221.176.200.22/zkhotline/website/webManage_customerPage.action');
        // //A-Z的字母列表每条数据是在id=letter-focus 的div内class= letter-focus-item的dl标签内，用find方法查找即为 
        // $arr=array();
        // var_dump($html);exit;
        // foreach($html->find('#Table1 tbody tr th') as $element)
        // {
        //     $arr[]= $element->innertext . '<br>';
        // }
        
        
        // $fileName='data.txt';//不用事先建好
        // $arrLen=count($arr);
        // for($i=0;$i<$arrLen;$i++){
        // file_put_contents($fileName,$arr[$i],FILE_APPEND|LOCK_EX);
        // /*FILE_APPEND|LOCK_EX是往后追加数据，如果没有该参数，则只能插入一条数据
        //     但是如果重新启动抓取时，则会将以往抓取过的数据继续存入*/
        // }
        // //以上是抓取的数据然后存到data.text里
        // $content=file_get_contents($fileName);
        // $cont=explode("<br>",$content);
        // $contLen=count($cont);
        // for($i=0;$i<$contLen;$i++) {
        //     unset($cont[2*$i+1]);
        // }  
       
    }

}
