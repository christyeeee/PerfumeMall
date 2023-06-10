<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
class Index extends Controller
{
    public function index()
    {
        $pclass=Db::table('perfume')->distinct('true')->field('pclass')->select();
        $this->assign('pclasses',$pclass);
//         return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
        
        $pname=input('post.pname');
        $fcls=input('post.fcls');
        $minprice=input('post.minprice');
        $maxprice=input('post.maxprice');
        
        if (empty($maxprice)){
            $maxprice=PHP_INT_MAX;
        }        
        if (empty($minprice)){
            $minprice=0;
        }
        
        $searchstr="yourprice between $minprice and $maxprice";
        if (!empty($pname)){
            $searchstr.=" and pname like '%$pname%'";
        }
        if (!empty($fcls)){
            $searchstr.=" and pclass='$fcls'";
        }
        
        $data=Db::table('perfume')->where($searchstr)->order('SelledNum desc')->select();
        $this->assign('perfumes',$data);
        return $this->fetch();
        
//         return view();
        
    }
    
    public function showperfume(){
        $data = Db::table('perfume')->order('SelledNum','desc')->paginate(5);
        $this->assign('result',$data);
        $page=$data->render();
        $this->assign('page',$page);
        return $this->fetch();
    }
}
