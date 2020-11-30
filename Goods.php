<?php

namespace app\home\controller;

use app\home\model\Cart;
use think\Controller;
use think\Request;

class Goods extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //查询出所有的商品
        $goods = \app\home\model\Goods::alias("t1")
            ->join("spec_goods t2","t1.id = t2.goods_id","left")
            ->field("t1.*,t2.value_names,t2.price,t2.goods_number")
            ->select();
        return view("list",['goods'=>$goods]);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //接收参数
        $param = $request->param();
        //验证数据
        $result = $this->validate($param,
            [
                'goods_id|商品'  => 'require|number|gt:0',
                'number|数量'   => 'require|number|gt:0',
            ]);
        if(true !== $result){
            // 验证失败 输出错误信息
            $this->error($result);
        }
        //判断用户是否登录
        $user_id = session("user")['id'];
        if (empty($user_id)){
            $this->success("请您先登录","home/index/login");
        }
        //拼写条件
        $where['user_id'] = $user_id;
        $where['goods_id'] = $param['goods_id'];
        //查询该商品数据是否存在，
        $goods = Cart::where($where)->find();
        if ($goods){
            //如果存在那么修改数量
            $res = Cart::update(['number'=>$goods['number']+$param['number']],$where);
        }else{
            //如果不存在那么直接添加数据
            $res = Cart::create(['user_id'=>$user_id,'goods_id'=>$param['goods_id'],'number'=>$param['number']]);
        }
        if ($res){
            $this->success("添加成功","home/Cart/index");
        }else{
            $this->error("系统繁忙，请稍后重试");
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //验证参数
        if (!is_numeric($id)){
            $this->error("参数格式错误");
        }
        //查询该条数据
        $goods = \app\home\model\Goods::alias("t1")
            ->join("spec_goods t2","t1.id = t2.goods_id","left")
            ->field("t1.*,t2.value_names,t2.price,t2.goods_number")
            ->find($id);
        // 返回到视图
        return view("item",['goods'=>$goods]);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
