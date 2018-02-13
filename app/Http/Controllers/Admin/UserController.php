<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use App\Models\Company;
use App\Models\Config;
use App\Models\WxUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Psy\Util\Json;

class UserController extends Controller
{
    public $grade;

    public function __construct()
    {
        $grade = Config::where('type', 'grade')->get();
        foreach ($grade as $k => $v) {
            $data[$v->id]['id'] = $v->id;
            $data[$v->id]['name'] = $v->name;
            $data[$v->id]['value'] = $v->value;
        }
        $this->grade = $data;
    }

    public function index()
    {
        return view('admin.user.index');
    }

    public function store(Request $request)//获取列表数据 post
    {
        $key = $request->input('key');
        $query = WxUser::query();
        if (isset($key['type']) && $key['type'] == 1) {
            $query->where('name', 'like', '%' . $key['value'] . '%')
                ->orWhere('phone', 'like', '%' . $key['value'] . '%');
        }
        $res = $query->get();
        foreach ($res as $k => $v) {
            if (empty($v['grade'])) {//没有设置等级
                $grade = $this->jifendengji($v->integral);
                $res[$k]['grade'] = $this->grade[$grade]['name'];
            } elseif ($v->autoex == 0) {//设置等级,自动升级
                $yid = $v['grade'];//设置的等级id
                $xid = $this->jifendengji($v->integral);//积分对应的等级
                //现在积分对应的等级高于设置对应的等级
                if ($v->integral > $this->grade[$yid]['value']) {
                    $res[$k]['grade'] = $this->grade[$xid]['name'];
                } else {
                    $res[$k]['grade'] = $this->grade[$yid]['name'];
                }
            } elseif ($v->autoex == 1) {//设置登录,固定等级
                $res[$k]['grade'] = $this->grade[$v['grade']]['name'];
            }
        }
        return ['code' => 0, 'msg' => '', 'count' => '', 'data' => $res];
    }

    //积分对应等级
    function jifendengji($jifen)
    {
        $dengji = '';
        foreach ($this->grade as $v) {
            if ($jifen >= $v['value']) {
                $dengji = $v['id'];
            }
        }
        return $dengji;
    }

    public function show($id)//创建或修改显示页
    {
        $res = [];
        if ($id == 0) {
        } else {
            $query = WxUser::query();
            $res = $query->where('id', $id)->first();
            $grade = Config::where('type', 'grade')->get();
            $area = Area::get();
            $tem = Company::get()->toArray();
        }
        return view('admin.user.show', ['department' => $tem, 'data' => $res, 'grade' => $grade, 'area' => $area]);
    }

    public function show_baimingdan(Request $request)
    {
        $tem = $request->input('tem');
        $grade = Config::where('type', 'grade')->get();
        return view('admin.user.baimingdan', ['grade' => $grade, 'tem' => json_encode($tem)]);
    }

    public function action_baimingdan(Request $request)
    {
        $tem = $request->input('tem');
        $tem = json_decode(htmlspecialchars_decode($tem));

        $data = $request->input('data');
        for ($i = 0; $i < count($tem); $i++) {
            $wxuser = WxUser::find($tem[$i]);
            $wxuser->grade = $data['grade'];
            $wxuser->exception = 1;
            $wxuser->autoex = $data['autoex'];
            $wxuser->save();
        }
        return ['status' => 1];

    }

    public function baimingdan()
    {
        return view('admin.user.baimingdan_guanli');
    }

    public function baimingdandate()
    {
        $data = WxUser::with('grade')->where('exception', 1)->get()->toArray();
        foreach ($data as $k => $v) {
            $data[$k]['grade_name'] = $v['grade'][0]['name'];
        }
        return ['code' => 0, 'msg' => '', 'count' => '', 'data' => $data];
    }

    public function baimingdandateAction(Request $request, $id)
    {
        $data = $request->input('tem');
        $type = $request->input('type');
        if ($type == 2) {
            $wxuser = WxUser::find($id);
            $wxuser->exception = 0;
            $wxuser->save();
        } elseif ($type == 1) {
            for ($i = 0; $i < count($data); $i++) {
                $wxuser = WxUser::find($data[$i]);
                $wxuser->exception = 0;
                $wxuser->save();
            }
        }
        return ['status' => 1];

    }

    public function update(Request $request, $id)//新增修改逻辑
    {
        $data = $request->input('data');
        $type = $request->input('type');
        if (!empty($type) && $type == 1) {
            $tem = WxUser::find($id);
            $tem->company_id = $data['company_id'];
            $tem->name = $data['name'];
            $tem->phone = $data['phone'];
            $tem->sex = $data['sex'];
            $tem->grade = $data['grade'];
            $tem->autoex = $data['autoex'];
            $tem->autoex = $data['autoex'];
            $tem->email = $data['email'];
            $tem->company = $data['company'];
            $tem->area = $data['area'];
            $tem->department = $data['department'];
            $tem->duty = $data['duty'];
            $tem->ide = $data['ide'];
            $tem->idenum = $data['idenum'];
            $tem->created_at = $data['created_at'];
            $tem->save();
        } elseif (!empty($type) && $type == 2) {
            $tem = WxUser::find($id);
            $tem->exception = 1;
            $tem->save();

        }
        return ['status' => 1];
    }

    public function destroy($id)//删除
    {
        $query = Company::query();
        $query->where('id', $id)->delete();
    }

}
