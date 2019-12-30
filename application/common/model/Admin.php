<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{

    //软删除
    use SoftDelete;
    //登录校验
    public function login($data){

        $validate = new \app\common\validate\Admin();

        if (!$validate->scene('login')->check($data)){

            return $validate->getError();
        }

        $result = $this->where($data)->find();
        if($result){
            //判断用户是否可用
            if ($result['status'] != 1){
                return '此账户被禁用！';
            }
            //1表示有这个用户，也就是用户名和密码正确了
            $sessionData = [
                'id' => $result['id'],
                'nickname' => $result['nickname'],
                'is_super' => $result['is_super']
            ];
            session('admin',$sessionData);
            return 1;
        }else{
            return '用户名或者密码错误！';
        }

    }

    //注册
    public function register($data){

        $validate = new \app\common\validate\Admin();

        if (!$validate->scene('register')->check($data)){

            return $validate->getError();
        }

        //去掉确认密码字段unset($data['conpass']);
        $result = $this->allowField(true)->save($data);
        mailto($data['email'],'z注册管理员成功!','注册管理员成功！');

        if ($result){
          return 1;
        }else{
            return '注册失败！';
        }
    }

    //重置密码
    public function reset($data){
        $validate = new \app\common\validate\Admin();


        if (!$validate->scene('reset')->check($data)){

            return $validate->getError();
        }

        if ($data['code'] !=session('code')){
            return '验证码不正确！';
        }
        $adminInfo = $this->where('email',$data['email'])->find();
        $adminInfo->password =$data['password'];
        $result= $adminInfo->save();
        if($result){
            return 1;
        }else{
            return '重置密码失败！';
        }

    }
}
