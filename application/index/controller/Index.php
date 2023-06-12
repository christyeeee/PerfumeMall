<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\console\input\Option;
use app\admin\controller\Perfume;
use function think\alert;
class Index extends Controller
{
    public function index()
    {
        $pclass=Db::table('perfume')->distinct('true')->field('pclass')->select();
        $this->assign('pclasses',$pclass);
        
        $pname=input('post.pname');
        $fcls=input('post.fcls');
        $minprice=input('post.minprice');
        $maxprice=input('post.maxprice');
        
        $fcls1 = $_POST["pclass"];       
       
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
        if (!empty($fcls1)){
            $searchstr.=" and pclass like '%$fcls1%'";
        }
        
                 
        
        
        $data=Db::table('perfume')->where($searchstr)->order('SelledNum desc')->select();
        $this->assign('perfumes',$data);
        return $this->fetch();
        
    }
    
//     public function sort(){
//         $sign = $_POST['select'];
//         $data = Db::table('perfume')
//                 ->order('SelledNum','desc')
//                 ->paginate(5);

//         $this->assign('sort',$data);
//         $page=$data->render();
//         $this->assign('page1',$page);
//         return $this->fetch();
//     }
    
    public function showperfume(){      
        $data = Db::table('perfume')
        ->order('SelledNum','desc')
        ->paginate(5);
        $this->assign('result',$data);
        $page=$data->render();
        $this->assign('page',$page);
        return $this->fetch();
    }
}