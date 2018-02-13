<?php

namespace App\Http\Controllers\Admin;

use App\Models\Config;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\WxUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.coupons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *得到优惠券信息
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $query = Coupon::query();
        $res = $query->get();
        for ($i = 0; $i < count($res); $i++) {
            if (strtotime($res[$i]['end']) < time()) {
                $res[$i]['status'] = 2;
            }
        }
        return ['code' => 0, 'msg' => '', 'count' => '', 'data' => $res];
    }

    /**
     * Display the specified resource.
     *修改优惠券界面
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $res = [];
        if ($id == 0) {

        } else {
            $query = Coupon::query();
            $res = $query->where('id', $id)->first();
        }
        return view('admin.coupons.show', ['data' => $res]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * 新增或修改优惠券信息
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        $data = $request->input('data');
        if (isset($data['name'])) {
            $data['name'] = ltrim($data['name'], ",");
            $data['value'] = ltrim($data['value'], ",");
            $data['reggive'] = ltrim($data['reggive'], ",");
            $data['limit'] = ltrim($data['limit'], ",");
            $data['start'] = ltrim($data['start'], ",");
            $data['end'] = ltrim($data['end'], ",");
            $data['describe'] = ltrim($data['describe'], ",");
        }
        $query = Coupon::query();
        if ($id == 0) {
            $query->create($data);
        } else {
            $query->where('id', $id)->update($data);
        }
        return ['status' => 1];
    }

    /**
     *
     * 优惠券删除
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return array
     */
    public function destroy($id)
    {
        Coupon::destroy($id);
        return ['status' => 1];
    }

    /**
     * 发送优惠券
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendCoupon($id)
    {
        $query = Config::query();
        $level = $query->where('type', 'grade')->get();
        return view('admin.coupons.send', ['id' => $id, 'level' => $level]);
    }

    /**
     *
     * 赠送优惠券
     * @param Request $request
     * @param $id
     * @return array
     */
    public function sendCouponAction(Request $request, $id)
    {
        $tem = $request->input('data');
        if ($tem['type'] == 0 && isset($tem['tem'])) {
            $data = $tem['tem'];
        } else {
            $data = self::selectmemenber($tem['type'], $tem['value']);
        }

        for ($i = 0; $i < count($data); $i++) {
            $model = new CouponUser();
            $model->openid = $data[$i]['id'];
            $model->coupon_id = $id;
            $model->save();
        }
        return ['status' => 1];

    }

    /**
     *
     * 赠送优惠券进行判断的方法
     * 会员等级来进行判断
     * @param $type
     * @param $value
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function selectmemenber($type, $value)
    {
        $tem = [];
        if ($type == 'all') {
            $tem = WxUser::select(['id'])->get();
        } elseif ($type == 'grade') {
            $tem = WxUser::select(['id'])->where('grade', $value)->get();
        } else {
            $tem = WxUser::select(['id'])->where('exception', 1)->get();
        }
        return $tem;

    }

    /**
     *
     * 优惠券统计界面显示
     */
    public function sendCoupontatol()
    {
        return view('admin.coupons.use_statistics');
    }

    /**
     *给优惠券统计界面传值
     */
    public function dataCoupontatol()
    {
        $data = Coupon::with(['nums' => function ($query) {
            $query->select(DB::raw('count(id) as num, coupon_id'))->groupBy('coupon_id');
        }, 'no_use_num' => function ($query) {
            $query->select(DB::raw('count(id) as no_use_num, coupon_id'))->where('status', 0)->groupBy('coupon_id');
        }])->get()->toArray();
        foreach ($data as $k => $v) {
            $data[$k]['num'] = 0;
            $data[$k]['no_use_num'] = 0;
            if (isset($v['nums'][0]['num'])) {
                $data[$k]['num'] = $v['nums'][0]['num'];
                $data[$k]['no_use_num'] = $v['no_use_num'][0]['no_use_num'];
            }
        }
        return ['code' => 0, 'msg' => '', 'count' => '', 'data' => $data];
    }

    /**
     *
     * 赠送优惠券中的查询人员名单
     *
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {
        $tem = [];
        $data = $request->input('key');
        if (isset($data['type'])) {
            $tem = WxUser::where('name', 'like', '%' . $data['value'] . '%')
                ->orWhere('phone', 'like', '%' . $data['value'] . '%')
                ->with('grade')->get()->toArray();
        }
        foreach ($tem as $k=>$v){
            $tem[$k]['grade_name']=$tem[$k]['grade'][0]['name'];
        }

        return ['status' => 1, 'code' => 0, 'msg' => '', 'count' => '', 'data' => $tem];
    }

}
