<?php


namespace app\common\validate;


use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'username|管理员账户' => 'require',
        'password|新密码' => 'require',

        'conpass|确认密码' => 'require|confirm:password',
        'nickname|昵称' => 'require',
        'email|邮箱' => 'require|email|unique:admin',
        'code|验证码' => 'require'
    ];

    protected $message=[
        'compass.confirm' => '两次密码输入不一致！'
    ];

    //登录验证场景
    public function sceneLogin()
    {

        return $this->only(['username', 'password']);
    }
    //注册场景验证
    public function sceneRegister()
    {

        return $this->only(['username', 'password','conpass','nickname','email'])
            ->append('username','unique:admin');
    }

    //重置密码
    public function sceneReset(){
        return $this->only(['code','password','conpass']);
    }
}