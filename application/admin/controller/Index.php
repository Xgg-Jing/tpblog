<?php

namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    //重复登录过滤
    public function initialize()
    {
        if (session('?admin.id')){
            $this->redirect('admin/home/index');
        }
    }

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
     //注册
    public function register(){
        if(request()->isAjax()){
            $data = [
              'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass' => input('post.conpass'),
              'nickname' => input('post.nickname'),
                'email'  => input('email')
            ];

            $result = model('Admin')->register($data);
            if ($result == 1){
                $this->success('注册成功','admin/index/login');
            }else{
                $this->error($result);
            }
        }
        return view();
    }
    //忘记密码,发送验证码
    public function forget(){
        if (request()->isAjax()){
            $code =mt_rand(1000,9999);
            session('code',$code);
            $data = [
                'email' =>input('post.email')
            ];
            $result = $this->validate(
              $data,
                [
                    'email'   => 'require|email',
                ]);
            if(true !== $result){
                // 验证失败 输出错误信息
               return $this->error('请输入正确的邮箱！');
            }


            $result = mailto($data['email'],'重置密码验证码','您的重置密码验证码是：'.$code);
            if ($result){
                $this->success('验证码发送成功！');
            }else{
                $this->error('验证码发送失败！');
            }
        }
    return view();
    }

    //重置密码
    public function reset(){
        $data =[
            'email' => input('post.email'),
            'code'=> input('post.code'),
            'password' => input('post.newpass'),
            'conpass'  => input('post.connew')
        ];
        $result = model('Admin')->reset($data);
        if ($result == 1){
            $this->success('密码重置成功！','admin/index/login');
        }else{
            $this->error($result);
        }

        return view();
    }
}
