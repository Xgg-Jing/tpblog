<?php

namespace app\admin\controller;

use think\Controller;

class Cate extends Base
{
    public function list(){

        return view();

    }
     public function add(){
        if (request()->isAjax()){
            $data = [
                'catename' => input('post.catename'),
                'sort' => input('post.sort')
            ];
            model('cate')
        }
        return view();
     }
}
