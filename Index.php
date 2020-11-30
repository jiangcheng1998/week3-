<?php

namespace app\home\controller;

use app\home\model\User;
use think\Controller;
use think\Request;

class Index extends Controller
{
    /**
     * 渲染用户登录模板
     * @return \think\Response
     */
    public function login()
    {
        //返回登录的视图
        return view("login");
    }

    /**
     * 用户登录
     * @param Request $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function loginDo(Request $request){
        //接收数据
        $param = $request->param();
        //验证数据
        $result = $this->validate($param,
            [
                'username|用户名'  => 'require',
                'pwd|密码'   => 'require',
            ]);
        if(true !== $result){
            // 验证失败 输出错误信息
            $this->error($result);
        }
        //设置查询条件
        $where['pwd'] = md5($param['pwd']);
        $where['username'] = $param['username'];
        //查询数据
        $res = User::where($where)->find();
        if ($res){
            session("user",$res);
            $this->redirect("home/goods/index");
        }else{
            $this->error('用户名或者密码错误');
        }
    }
}
