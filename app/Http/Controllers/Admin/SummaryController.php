<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SummaryController extends Controller
{
    //
    /**
     * 订单收入
     *
     */
    public function orderincome()
    {

        return view('admin.summary.orderincome');

    }

    /**
     * 订单收入获取数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orderincomedata(Request $request)
    {
        $tem = $request->input('key');
        if (isset($tem['type'])) {
            $date1 = substr($tem['value'], 0, 10);
            $date2 = substr($tem['value'], 13, 10);
            $data = Order::where('year_month_day', '>', $date1)
                ->where('year_month_day', '<', $date2)
                ->where('status', '>=', 1)
                ->get()->toArray();
        } else {
            $data = Order::where('status', '>=', 1)->get()->toArray();
        }
        foreach ($data as $k => $v) {
            $data[$k]['name_phone'] = $v['name'] . '-' . $v['phone'];
            $data[$k]['total_price'] = '+' . $v['total'];
            if ($v['status'] == 1) {
                $data[$k]['message'] = '未处理';
            } elseif ($v['status'] >= 1) {
                $data[$k]['message'] = '已同意';
            }
        }
        return ['code' => 0, 'msg' => '', 'count' => '', 'data' => $data];
    }

    /**
     *退款记录
     */
    public function refunds_record()
    {
        return view('admin.summary.refunds_record');
    }

    /**
     * 退款记录获取数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refunds_record_data()
    {
        $data = Order::where('status', 4)->get();
        foreach ($data as $k => $v) {
            $data[$k]['name_phone'] = $v['name'] . '-' . $v['phone'];
            $data[$k]['total_price'] = '-' . $v['total'];
            if ($v['efundablestatus'] == 1) {
                $data[$k]['message'] = '已同意';
            } elseif ($v['efundablestatus'] >= 0) {
                $data[$k]['message'] = '已拒绝';
            } else {
                $data[$k]['message'] = '未处理';
            }
        }
        return ['code' => 0, 'msg' => '', 'count' => '', 'data' => $data];
    }

    /**
     *日对账单
     */
    public function daily_bill()
    {
        return view('admin.summary.daily_bill');
    }

    /**
     * 日对账单获取数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function daily_bill_data(Request $request)
    {
        $tem = $request->input('key');

        if (isset($tem['type']) && $tem['type'] == 1) {
            $price = Order::select(DB::raw('sum(total) as total_price,ordertime'))
                ->where('ordertime', $tem['value'])
                ->where('status', '>=', 1)
                ->groupBy('ordertime', 'status')
                ->get()->toArray();
            $data = Order::select(DB::raw('count(id) as total_nums,ordertime'))
                ->where('ordertime', $tem['value'])
                ->groupBy('ordertime')
                ->get()->toArray();
            $res_num = Order::select(DB::raw('sum(total) as total_res_price,ordertime'))
                ->where('status', 4)
                ->where('ordertime', $tem['value'])
                ->groupBy('ordertime', 'status')
                ->get()->toArray();
        } else {
            $price = Order::select(DB::raw('sum(total) as total_price,ordertime'))
                ->where('status', '>=', 1)
                ->groupBy('ordertime')
                ->get()->toArray();
            $data = Order::select(DB::raw('count(id) as total_nums,ordertime'))
                ->groupBy('ordertime')
                ->get()->toArray();
            $res_num = Order::select(DB::raw('sum(total) as total_res_price,ordertime'))
                ->where('status', 4)
                ->groupBy('ordertime')
                ->get()->toArray();
        }
        foreach ($price as $k => $v) {
            for ($i = 0; $i < count($data); $i++) {
                if ($v['ordertime'] == $data[$i]['ordertime']) {
                    $data[$i]['total_price'] = $v['total_price'];
                    break;
                }
            }
        }
        foreach ($res_num as $k => $v) {
            for ($i = 0; $i < count($data); $i++) {
                if ($v['ordertime'] == $data[$i]['ordertime']) {
                    $data[$i]['total_res_price'] = '-' . $v['total_res_price'];
                    break;
                }
            }
        }
        foreach ($data as $k => $v) {
            if (!isset($v['total_price'])) {
                $data[$k]['total_price'] = 0;
            }
            if (!isset($v['total_res_price'])) {
                $data[$k]['total_res_price'] = 0;
            }
            $data[$k]['total'] = $data[$k]['total_price'] + $data[$k]['total_res_price'];
        }
        return ['code' => 0, 'msg' => '', 'count' => '', 'data' => $data];
    }

    /**
     *月对账单
     */
    public function month_bill()
    {
        return view('admin.summary.month_bill');
    }

    /**
     * 月对账单获取数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function month_bill_data(Request $request)
    {
        $key = $request->input('key');
        $query = Order::query();
        $price = $query->select(DB::raw('sum(total) as total_price'), 'year_month')
            ->where('status', '>=', 1)->groupBy('year_month');
        if (isset($key['type']) && $key['type'] == 1) {
            $price = $query->having('year_month', $key['value']);
        }
        $price = $query->get()->toArray();
        $data = $query->select(DB::raw('count(id) as total_nums'), 'year_month')
            ->groupBy('year_month');
        if (isset($key['type']) && $key['type'] == 1) {
            $data = $query->having('year_month', $key['value']);
        }
        $data = $query->get()->toArray();
        $res_num = $query->select(DB::raw('sum(total) as total_res_price'), 'year_month')
            ->where('status', 4)->groupBy('year_month');
        if (isset($key['type']) && $key['type'] == 1) {
            $res_num = $query->having('year_month', $key['value']);
        }
        $res_num = $query->get()->toArray();
        foreach ($price as $k => $v) {
            for ($i = 0; $i < count($data); $i++) {
                if ($v['year_month'] == $data[$i]['year_month']) {
                    $data[$i]['total_price'] = $v['total_price'];
                    break;
                }
            }
        }
        foreach ($res_num as $k => $v) {
            for ($i = 0; $i < count($data); $i++) {
                if ($v['year_month'] == $data[$i]['year_month']) {
                    $data[$i]['total_res_price'] = '-' . $v['total_res_price'];
                    break;
                }
            }
        }
        foreach ($data as $k => $v) {
            if (!isset($v['total_price'])) {
                $data[$k]['total_price'] = 0;
            }
            if (!isset($v['total_res_price'])) {
                $data[$k]['total_res_price'] = 0;
            }
            $data[$k]['total'] = $data[$k]['total_price'] + $data[$k]['total_res_price'];
        }

        return ['code' => 0, 'msg' => '', 'count' => '', 'data' => $data];
    }

    /**
     *
     * 订单收入导出
     * @param Request $request
     */
    public function borrowrecordExcel(Request $request)
    {
        $type = $request->input('type');
        $value = $request->input('value');
        if ($type == 1) {
            $date1 = substr($value, 0, 10);
            $date2 = substr($value, 13, 10);
            $record = Order::where('year_month_day', '>', $date1)
                ->where('year_month_day', '<', $date2)
                ->where('status', '>=', 1)
                ->get()->toArray();
        } else {
            $record = Order::where('status', '>=', 1)->get()->toArray();
        }
        foreach ($record as $k => $v) {
            $record[$k]['name_phone'] = $v['name'] . '-' . $v['phone'];
            $record[$k]['total_price'] = '+' . $v['total'];
            if ($v['status'] == 1) {
                $record[$k]['message'] = '未处理';
            } elseif ($v['status'] >= 1) {
                $record[$k]['message'] = '已同意';
            }
        }
        Excel::create(date('Y_m_d H_i_s'), function ($excel) use ($record) {
            $excel->sheet('Excel sheet', function ($sheet) use ($record) {
                $sheet->prependRow(1, ['订单编号', '时间', '顾客姓名/电话', '金额(元)', '状态']);
                for ($i = 2; $i < count($record) + 2; $i++) {

                    $sheet->row($i, [
                        $record[$i - 2]['order_id'],
                        $record[$i - 2]['ordertime'],
                        $record[$i - 2]['name_phone'],
                        $record[$i - 2]['total_price'],
                        $record[$i - 2]['message']]);
                    $sheet->setWidth([
                        'A' => 15,
                        'B' => 10,
                        'C' => 20,
                        'D' => 10,
                        'E' => 10
                    ]);
                }
            });
        })->export('xls');
    }

    /**
     *
     * 日对账单导出
     * @param Request $request
     */
    public function daily_borrowrecordExcel(Request $request)
    {
        $type = $request->input('type');
        $value = $request->input('value');
        if (isset($type) && $type == 1) {
            $price = Order::select(DB::raw('sum(total) as total_price,ordertime'))
                ->where('ordertime', $value)
                ->where('status', '>=', 1)
                ->groupBy('ordertime', 'status')
                ->get()->toArray();
            $record = Order::select(DB::raw('count(id) as total_nums,ordertime'))
                ->where('ordertime', $value)
                ->groupBy('ordertime')
                ->get()->toArray();
            $res_num = Order::select(DB::raw('sum(total) as total_res_price,ordertime'))
                ->where('status', 4)
                ->where('ordertime', $value)
                ->groupBy('ordertime', 'status')
                ->get()->toArray();
        } else {
            $price = Order::select(DB::raw('sum(total) as total_price,ordertime'))
                ->where('status', '>=', 1)
                ->groupBy('ordertime')
                ->get()->toArray();
            $record = Order::select(DB::raw('count(id) as total_nums,ordertime'))
                ->groupBy('ordertime')
                ->get()->toArray();
            $res_num = Order::select(DB::raw('sum(total) as total_res_price,ordertime'))
                ->where('status', 4)
                ->groupBy('ordertime')
                ->get()->toArray();
        }
        foreach ($price as $k => $v) {
            for ($i = 0; $i < count($record); $i++) {
                if ($v['ordertime'] == $record[$i]['ordertime']) {
                    $record[$i]['total_price'] = $v['total_price'];
                    break;
                }
            }
        }
        foreach ($res_num as $k => $v) {
            for ($i = 0; $i < count($record); $i++) {
                if ($v['ordertime'] == $record[$i]['ordertime']) {
                    $record[$i]['total_res_price'] = '-' . $v['total_res_price'];
                    break;
                }
            }
        }
        foreach ($record as $k => $v) {
            if (!isset($v['total_price'])) {
                $record[$k]['total_price'] = 0;
            }
            if (!isset($v['total_res_price'])) {
                $record[$k]['total_res_price'] = 0;
            }
            $record[$k]['total'] = $record[$k]['total_price'] + $record[$k]['total_res_price'];
        }

        Excel::create(date('Y_m_d H_i_s'), function ($excel) use ($record) {
            $excel->sheet('Excel sheet', function ($sheet) use ($record) {
                $sheet->prependRow(1, ['日期', '订单数量', '订单总金额(元)', '退款总金额(元)', '结算小计']);
                for ($i = 2; $i < count($record) + 2; $i++) {

                    $sheet->row($i, [
                        $record[$i - 2]['ordertime'],
                        $record[$i - 2]['total_nums'],
                        $record[$i - 2]['total_price'],
                        $record[$i - 2]['total_res_price'],
                        $record[$i - 2]['total']]);
                    $sheet->setWidth([
                        'A' => 15,
                        'B' => 10,
                        'C' => 20,
                        'D' => 10,
                        'E' => 10
                    ]);
                }
            });
        })->export('xls');
    }

    /**
     *
     * 月对账单导出
     * @param Request $request
     */
    public function month_borrowrecordExcel(Request $request)
    {
        $type = $request->input('type');
        $value = $request->input('value');
        $query = Order::query();
        $query->select(DB::raw('sum(total) as total_price'), 'year_month')
            ->where('status', '>=', 1)->groupBy('year_month');
        if (isset($type) && $type == 1) {
            $query->having('year_month', $value);
        }
        $price = $query->get()->toArray();
        $query->select(DB::raw('count(id) as total_nums'), 'year_month')
            ->groupBy('year_month');
        if (isset($type) && $type == 1) {
            $query->having('year_month', $value);
        }
        $record = $query->get()->toArray();
        $query->select(DB::raw('sum(total) as total_res_price'), 'year_month')
            ->where('status', 4)->groupBy('year_month');
        if (isset($type) && $type == 1) {
            $query->having('year_month', $value);
        }
        $res_num = $query->get()->toArray();
        foreach ($price as $k => $v) {
            for ($i = 0; $i < count($record); $i++) {
                if ($v['year_month'] == $record[$i]['year_month']) {
                    $record[$i]['total_price'] = $v['total_price'];
                    break;
                }
            }
        }
        foreach ($res_num as $k => $v) {
            for ($i = 0; $i < count($record); $i++) {
                if ($v['year_month'] == $record[$i]['year_month']) {
                    $record[$i]['total_res_price'] = '-' . $v['total_res_price'];
                    break;
                }
            }
        }
        foreach ($record as $k => $v) {
            if (!isset($v['total_price'])) {
                $record[$k]['total_price'] = 0;
            }
            if (!isset($v['total_res_price'])) {
                $record[$k]['total_res_price'] = 0;
            }
            $record[$k]['total'] = $record[$k]['total_price'] + $record[$k]['total_res_price'];
        }

        Excel::create(date('Y_m_d H_i_s'), function ($excel) use ($record) {
            $excel->sheet('Excel sheet', function ($sheet) use ($record) {
                $sheet->prependRow(1, ['日期', '订单数量', '订单总金额(元)', '退款总金额(元)', '结算小计']);
                for ($i = 2; $i < count($record) + 2; $i++) {

                    $sheet->row($i, [
                        $record[$i - 2]['ordertime'],
                        $record[$i - 2]['total_nums'],
                        $record[$i - 2]['total_price'],
                        $record[$i - 2]['total_res_price'],
                        $record[$i - 2]['total']]);
                    $sheet->setWidth([
                        'A' => 15,
                        'B' => 10,
                        'C' => 20,
                        'D' => 10,
                        'E' => 10
                    ]);
                }
            });
        })->export('xls');
    }

    /**
     *
     * 退款订单导出
     * @param Request $request
     */
    public function refunds_borrowrecordExcel()
    {
        $record = Order::where('status', 4)->get();
        foreach ($record as $k => $v) {
            $record[$k]['name_phone'] = $v['name'] . '-' . $v['phone'];
            $record[$k]['total_price'] = '-' . $v['total'];
            if ($v['efundablestatus'] == 1) {
                $record[$k]['message'] = '已同意';
            } elseif ($v['efundablestatus'] >= 0) {
                $record[$k]['message'] = '已拒绝';
            } else {
                $record[$k]['message'] = '未处理';
            }
        }

        Excel::create(date('Y_m_d H_i_s'), function ($excel) use ($record) {
            $excel->sheet('Excel sheet', function ($sheet) use ($record) {
                $sheet->prependRow(1, ['订单编号', '时间', '顾客姓名/电话', '金额(元)', '退款原因', '状态']);
                for ($i = 2; $i < count($record) + 2; $i++) {

                    $sheet->row($i, [
                        $record[$i - 2]['order_id'],
                        $record[$i - 2]['ordertime'],
                        $record[$i - 2]['name_phone'],
                        $record[$i - 2]['total_price'],
                        $record[$i - 2]['remark'],
                        $record[$i - 2]['message']
                    ]);
                    $sheet->setWidth([
                        'A' => 15,
                        'B' => 10,
                        'C' => 20,
                        'D' => 10,
                        'E' => 10
                    ]);
                }
            });
        })->export('xls');
    }
}
