<?php

namespace app\home\controller;

use think\Controller;
use think\Request;

class Cart extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //获取用户的id
        $user_id = session("user")['id'];
        //查询数据
        $data = \app\home\model\Cart::where('user_id',$user_id)->select();
        foreach ($data as $val){
            //查询出所有的商品
            $goods[$val['id']] = \app\home\model\Goods::alias("t1")
                ->join("spec_goods t2","t1.id = t2.goods_id","left")
                ->field("t1.*,t2.value_names,t2.price,t2.goods_number")
                ->where("goods_id",$val['goods_id'])
                ->find()->toArray();
            $goods[$val['id']]['goods_number'] = $val['number'];
        }
        return view("list",['data'=>$goods]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
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
