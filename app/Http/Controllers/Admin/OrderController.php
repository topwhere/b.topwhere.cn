<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busines;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.order.index');
    }

    /**
     *
     * 获取退款订单数据
     *
     */
    public function create(Request $request)
    {
        $data = Order::where('status', 4)->get()->toArray();
        foreach ($data as $k => $v) {
            $data[$k]['time'] = $v['totime'] . '/' . $v['endtime'];
            $data[$k]['name_phone'] = $v['name'] . '/' . $v['phone'];
            if ($data[$k]['efundablestatus'] == 1) {
                $data[$k]['message'] = '已完成';
            } elseif ($data[$k]['efundablestatus'] == 0) {
                $data[$k]['message'] = '已拒绝';
            } else {
                $data[$k]['message'] = -1;
            }
        }
        return ['code' => 0, 'msg' => '', 'count' => '', 'data' => $data];
    }

    /**
     * 显示申请退款订单界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refundorder()
    {
        return view('admin.order.refundorder');
    }

    /**
     *订单退款界面处理
     */
    public function refundorderaction(Request $request, $id)
    {
        $data = $request->input('data');
        $model = Order::find($id);
        if ($data['type'] == 1) {
            $model->efundablestatus = 1;
        } elseif ($data['type' == 2]) {
            $model->efundablestatus = 0;
        }

        $model->refundprocessingtime = date("yy-m-d hh:mm:ss", time());
        $model->save();
        return ['status' => 1];

    }

    /**
     *
     * 获取订单列表数据
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $tem = $request->input('key');
        if (empty($tem['value'])) {
            $tem['value'] = '';
        }
        $data = Order::where('name', 'like', '%' . $tem['value'] . '%')->orWhere('phone', 'like', '%' . $tem['value'] . '%')->get()->toArray();
        foreach ($data as $k => $v) {
            $data[$k]['time'] = $v['totime'] . '-' . $v['endtime'];
            $data[$k]['name_phone'] = $v['name'] . '-' . $v['phone'];
            if ($data[$k]['status'] == 0) {
                $data[$k]['message'] = '代付款';
            } elseif ($data[$k]['status'] == 2) {
                if (strtotime($data[$k]['totime']) <= time()) {
                    $data[$k]['message'] = '已入住';
                } else {
                    $data[$k]['message'] = '未入住';
                }
            } elseif ($data[$k]['status'] == 3) {
                $data[$k]['message'] = '已拒绝';
            } elseif ($data[$k]['status'] == 4 && $data[$k]['efundablestatus'] == "") {
                $data[$k]['message'] = '申请退款';
            } elseif ($data[$k]['status'] == 4 && $data[$k]['efundablestatus'] == 1) {
                $data[$k]['message'] = '同意退款';
            } elseif ($data[$k]['status'] == 4 && $data[$k]['efundablestatus'] == 0) {
                $data[$k]['message'] = '拒绝退款';
            }
        }
        return ['code' => 0, 'msg' => '', 'count' => '', 'data' => $data];
    }


    function show($id)//创建或修改显示页
    {
        $data = Order::find($id);
        return view('admin.order.show', ['data' => $data]);
    }

    /**
     *
     * 点击确认或者拒绝按钮方法
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        $tem = $request->input('data');
        $data = Order::find($id);
        if ($tem['type'] == 2) {
            $data->status = 2;
        } elseif ($tem['type'] == 3) {
            $data->status = 3;
        } elseif ($tem['type'] == 4) {
           $data->remark=$tem['data']['value'];
        }
        $data->audittime = date("yyyy-mm-dd hh:mm:ss", time());
        $data->save();
        return ['status' => 1];
    }

    public function destroy($id)//删除
    {
        $query = Busines::query();
        $query->where('id', $id)->delete();
        return ['status' => 1];
    }
}
