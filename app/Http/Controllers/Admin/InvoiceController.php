<?php

namespace App\Http\Controllers\Admin;

use App\Models\InvoiceOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.invoice.index');
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
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tem = $request->input('key');
        if (isset($tem['type']) && $tem['type'] == 1) {
            $query = InvoiceOrder::query();
            $query->where('name', 'like', '%' . $tem['value'] . '%')
                ->orWhere('tel', 'like', '%' . $tem['value'] . '%');
            if ($tem['status'] == 0) {
                $query->where('status', 0);
            } elseif ($tem['status'] == 1) {
                $query->where('status', '>', 0);
            }
            $data = $query->get();

        } else {
            $data = InvoiceOrder::get();
        }
        foreach ($data as $k => $v) {
            $data[$k]['name_phone'] = $v['name'] . '/' . $v['tel'];
            $data[$k]['bank_num'] = $v['bank'] . '/' . $v['banknum'];
            if ($v['status'] == 1) {
                $data[$k]['message'] = '已完成';
            } elseif ($v['status'] == 2) {
                $data[$k]['message'] = '已取消';
            }
        }
        return ['code' => 0, 'msg' => '', 'count' => '', 'data' => $data];
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = InvoiceOrder::find($id);
        $data->status = 1;
        $data->save();
        return ['status' => 1];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
