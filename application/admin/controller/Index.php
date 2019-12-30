<?php

namespace app\admin\controller;

use app\common\model\Admin;
use think\Controller;

class Index extends Controller
{
    //登陆方法
    public function login(){
        if(request()->isAjax()){

            $data=[
                'username'=>input('post.username'),
                'password'=>input('post.password'),
            ];

            $result=model('Admin')->login($data);


            if ($result == 1){
                $this->success('登录成功！','admin/home/index');
            }else{
                $this->error($result);
            }

        }

        return view();
    }
}
