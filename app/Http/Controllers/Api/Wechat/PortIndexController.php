<?php

namespace App\Http\Controllers\Api\Wechat;

use App\Models\Classify;
use App\Models\Config;
use App\Models\Instrument;
use App\Models\LocalStock;
use App\Models\Record;
use App\Models\Version;
use App\Models\WxUser;
use App\Services\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class PortIndexController extends Controller
{
    public function __construct(Request $request)
    {
        $this->openid=$request->header('openid');
    }
    //获取用户信息
    public function getUser()
    {
        $wxuser=WxUser::where('openid',$this->openid)->select(['name','phone','address','job','group','status'])->with('groupv')->first();
        $wxuser->start_date=date('Y-m-d',time());
        $day="+".$wxuser->groupv->value." day";
        $wxuser->end_date=date('Y-m-d',strtotime($day));
        return $wxuser;
    }

    /**
     * @author 石头哥 sun@httproot.com
     * data:2017/11/8
     * @param unknown $
     * @return address
     */
    public function getFiliales(Request $request)
    {
        $res=Config::where('type','address')->get();
        return $this->change($res,'name');
    }

    /**
     * @author 石头哥 sun@httproot.com
     * data:2017/11/8
     * @param unknown $
     * @return Groups
     */
    public function getGroups(Request $request)
    {
        $res=Config::where('type','group')->get();
        return $this->change($res,'name');
    }
    //注册信息
    public function addUser(Request $request)
    {
//        return response('token 不对',401);
//        echo $this->openid;
        $data=$request->input();
        $data['status']=1;
        $data['submit_time']=time();
        $address=Config::where('type','address')->where('id',$data['filiale'])->first();
        $data['address']=$address['value'];
        WxUser::where('openid',$this->openid)->update($data);
        return ['status'=>1];
    }
    //借用的仪器
    public function instrument(Request $request)
    {
        $input=$request->input();
        $instrument=Instrument::query();
        $instrument->select(['id','classify_id','version_id','status','title','img','borrow']);
        $instrument->with('classify','version');
        if ($input['classify']>0){
            $instrument->where('classify_id',$input['classify']);
        }
        if ($input['version']>0){
            $instrument->where('version_id',$input['version']);
        }
        if ($input['registration']>0){
            $instrument->where('user_id',$input['registration']);
        }
        if ($input['status']!=2){
            $instrument->where('borrow',$input['status']);
        }
        $res=$instrument->get();
        foreach ($res as $k=>$v) {
            $res[$k]['img']=$_SERVER['HTTP_ORIGIN'].'/uploads/'.explode(',',$v['img'])[0];
        }
        $classify=Classify::select('id','title')->get();
        $classify=$this->change($classify,'title');
        $version=Version::select('id','title')->get();
        $version=$this->change($version,'title');
        $registration=WxUser::where('registration',1)->select(['id','name'])->get();
        $registration=$this->change($registration,'name');
        return ['res'=>$res,'classify'=>$classify,'version'=>$version,'registration'=>$registration];
    }

    protected function change($data,$old)
    {
        $date=[];
        foreach ($data as $k=>$v){
            $date[0]['id']='0';
            $date[0]['value']='不限';
            $date[$k+1]['id']=$v['id'];
            $date[$k+1]['value']=$v[$old];
        }
        return $date;
    }

    public function instrumentdetail(Request $request)//产品详情
    {
        $id=$request->input('id');
        $instrument=Instrument::where('id',$id)->with('classify','version','user')->first();
        $instrument->img=$_SERVER['HTTP_ORIGIN'].'/uploads/'.$instrument->img;
        $instrument->add_time=date('Y-m-d',$instrument->add_time);
        return $instrument;

    }

    public function applyfor(Request $request)//申请借用
    {
        $data=$request->input();
        $data['openid']=$request->user->id;
        $data['borrow_time']= strtotime($data['borrow_time']);
        $data['repay_time']= strtotime($data['repay_time']);
        $data['auditor_status']=0;
        unset($data['s']);
        $issave=Record::where('instrument_id',$data['instrument_id'])
            ->where('openid',$request->user->id)
            ->where('auditor_status',0)->first();
        if ($issave){
            return ['status'=>0,'msg'=>'您已申请此仪器,请勿重复提交'];
        }else{
            $rid=Record::create($data);
            $openid=WxUser::where('id',$data['have_id'])->first()['openid'];
            $url=getenv('APP_URL').'/wechat/instmdetail2.html?id='.$rid->instrument_id;
            $insr=Instrument::where('id',$data['instrument_id'])->with('classify','version')->first();
            $array=[
                'first'=>'您有一个新的借用申请',
                'keyword1'=>/*$v->id.*/'类型:'.$insr['classify']['title'].' 型号:'.$insr['version']['title'],
                'keyword2'=>date('Y/m/d',$data['borrow_time']),
                'keyword3'=>date('Y/m/d',$data['repay_time']),
                'remark'=>'借用者:'.$data['name'].' 电话:'.$data['phone'],
            ];
            self::tmplmsg($openid,$url,$array);
            return ['status'=>1,'msg'=>'提交成功'];
        }
    }
    public function audit(Request $request)//借用审核
    {
        $wait=Record::select(['id','instrument_id','openid','have_id','name','phone','auditor_status'])
            ->with(['classify','version'])
            ->where(function($query)use($request){
                $query->orwhere('have_id',$request->user->id)
                    ->orwhere('openid',$request->user->id);
            })->where('records.auditor_status',0)
            ->get();
        $end=Record::
            orderBy('id','desc')
            ->where(function($query)use($request){
            $query->orwhere('have_id',$request->user->id)
            ->orwhere('openid',$request->user->id);
            })
            ->with('classify','version')
            ->where('auditor_status','>',0)
            ->get();
        return ['wait'=>$wait,'end'=>$end];
    }

    public function instmdetail(Request $request)//审核详情页
    {
        $res=Record::where('id',$request->input('id'))->with('instrument','classify','version')->first();
        $res->instrument->img=$_SERVER['HTTP_ORIGIN'].'/uploads/'.$res->instrument->img;
        $res->instrument->add_time=date('Y-m-d',$res->instrument->add_time);
        $user_id=WxUser::where('id',$res->instrument->user_id)->select('name')->first()['name'];
        $res->instrument->user_id=$user_id;
        $res->borrow_time=date('Y-m-d',$res->borrow_time);
        $res->repay_time=date('Y-m-d',$res->repay_time);
        return $res;
    }

    public function auditport(Request $request)//审批操作
    {
        $data['record_remark']=$request->input('record_remark');
        //同意审批
        if ($request->input('auditor_status')=='ok'){
            $record=Record::where('id',$request->input('id'))->where('auditor_status',0)->where('have_id',$request->user->id)->first();
            $instrument=Instrument::where('id',$record->instrument_id)->first();
            //判断如果借用状态 是不可借用 或者 仪器状态是故障
            if ($instrument->status==0||$instrument->borrow==0){
                return ['auditor_status'=>2,'msg'=>'仪器故障或已借出,审核失败'];
            }
            $total_time=$instrument->total_time+$record->repay_time-$record->borrow_time;
            $total_num=++$instrument->total_num;
            $instr=['total_time'=>$total_time,'total_num'=>$total_num,'record_id'=>$request->input('id'),'borrow'=>0];
            Instrument::where('id',$record->instrument_id)->update($instr);
            $data=['auditor_status'=>1];
        }
        //拒绝审批
        if ($request->input('auditor_status')=='no'){
            $data=['auditor_status'=>2];
        }
        Record::where('id',$request->input('id'))
            ->where('auditor_status',0)
            ->where('have_id',$request->user->id)
            ->update($data);
        return $data;
    }

    public function myInstrument(Request $request)//我的仪器
    {
        $input=$request->input();
        $query=Instrument::query();
        if ($input['classify']>0){
            $query->where('classify_id',$input['classify']);
        }
        if ($input['version']>0){
            $query->where('version_id',$input['version']);
        }
        if ($input['status']!=2){
            $query->where('status',$input['status']);
        }
        $query->where('user_id',$request->user->id);
        $query->with('classify','version');
        $res=$query->get();
        foreach ($res as $k=>$v){
            $res[$k]['img']=$_SERVER['HTTP_ORIGIN'].'/uploads/'.$v['img'];
        }
        $classify=Classify::select('id','title')->get();
        $classify=$this->change($classify,'title');
        $version=Version::select('id','title')->get();
        $version=$this->change($version,'title');
        $registration=WxUser::where('registration',1)->select(['id','name'])->get();
        $registration=$this->change($registration,'name');
        return ['res'=>$res,'classify'=>$classify,'version'=>$version,'registration'=>$registration];
    }

    public function myinstmdetail(Request $request)//我的仪器详情页
    {
        $id=$request->input('id');
        $instrument=Instrument::where('id',$id)->with('classify','version','user','record')->first();
        $instrument->img=$_SERVER['HTTP_ORIGIN'].'/uploads/'.$instrument->img;
        $instrument->add_time=date('Y-m-d',$instrument->add_time);
        if ($instrument->record_id!==0){
            $instrument->day=floor(($instrument->record->repay_time-time())/60/60/24)+1;
            $instrument->record->borrow_time=date('Y-m-d',$instrument->record->borrow_time);
            $instrument->record->repay_time=date('Y-m-d',$instrument->record->repay_time);
        }
        return $instrument;
    }

    public function borrowed(Request $request)//我的借入
    {
        $input=$request->input();
        $query=Record::query();
        $query->where('openid',$request->user->id);
        $query->where('auditor_status',1);
        $query->where('status',2);
        if ($input['registration']!=0){
            $query->where('have_id',$input['registration']);
        }
        $query->with(['classify'=>function($query)use($input){
            if ($input['classify']!=0){
            $query->where('instruments.classify_id',$input['classify']);
            }
        },'version'=>function($query)use($input){
            if ($input['version']!=0){
                $query->where('instruments.version_id',$input['version']);
            }
        },'instrument'=>function($query)use($input){
            if ($input['status']!=2){
                $query->where('instruments.status',$input['status']);
            }
        }]);
        $res=$query->get();
        foreach ($res as $k=>$v){
            if ((!isset($v['instrument'])&&count($v['instrument'])==0)||count($v['classify'])==0||count($v['version'])==0){
                unset($res[$k]);
            }else{
                $res[$k]['instrument']['img']=$_SERVER['HTTP_ORIGIN'].'/uploads/'.$v['instrument']['img'];
            }
            $res[$k]['day']=floor(($v['repay_time']-time())/60/60/24)+1;

        }
        $classify=Classify::select('id','title')->get();
        $classify=$this->change($classify,'title');
        $version=Version::select('id','title')->get();
        $version=$this->change($version,'title');
        $registration=WxUser::where('registration',1)->select(['id','name'])->get();
        $registration=$this->change($registration,'name');
        return ['res'=>$res,'classify'=>$classify,'version'=>$version,'registration'=>$registration];
    }

    public function borrowedTail(Request $request)//我的借入点击详情
    {
        $record=Record::where('id',$request->input('id'))->with('classify','version','instrument','user')->first();
        $record->instrument->img=$_SERVER['HTTP_ORIGIN'].'/uploads/'.$record->instrument->img;
        $record->instrument->add_time=date('Y-m-d',$record->instrument->add_time);
        if ($record->record_id!==0){
            $record->day=floor(($record->repay_time-time())/60/60/24)+1;
            $record->borrow_time=date('Y-m-d',$record->borrow_time);
            $record->repay_time=date('Y-m-d',$record->repay_time);
        }
        return $record;
    }

    /**
     * @package 判断是否有需要邮寄的仪器
     * @author 石头哥 sun@httproot.com
     * data:2017/11/29
     * @param unknown $
     * @return array
     */
    public function mailcan(Request $request)
    {
        $record=Record::
        orwhere(function($query)use($request){
            $query->where('openid',$request->user->id)
                ->where('status',2);
        })
        ->orwhere(function($query)use($request){
            $query->where('have_id',$request->user->id)
                ->where('status',0);
        })
        ->first();
        if ($record){
            return ['status'=>1];
        }else{
            return ['status'=>0];
        }
    }
    /**
     * @package 判断是否有仪器需要接收
     * @author 石头哥 sun@httproot.com
     * data:2017/12/1
     * @param unknown $
     * @return unknown
     */
    public function acceptcan(Request $request){
        $record=Record::
        orwhere(function($query)use($request){
            $query->where('openid',$request->user->id)
                ->where('status',1);
        })
            ->orwhere(function($query)use($request){
                $query->where('have_id',$request->user->id)
                    ->where('status',3);
            })
            ->first();
        if ($record){
            return ['status'=>1];
        }else{
            return ['status'=>0];
        }
    }

    public function mailing(Request $request)//仪器邮寄
    {
        $insquery=Instrument::query();
        $insquery->where('id',$request->input('id'));
        $insquery->with('classify','version','record');
        $instrument=$insquery->first();
        $record=Record::where('instrument_id',$request->input('id'))
//            ->where('auditor_status',1)
            ->where(function ($query){$query->orwhere('status',0)->orwhere('status',2);})
            ->first();
        return ['instrument'=>$instrument,'record'=>$record];
    }

    public function mail(Request $request)//邮寄
    {
        $insquery=Instrument::where('id',$request->input('id'))->with('record')->first();
        $record=Record::query();
        $record->where('id',$insquery->record->id);
        if ($insquery->user_id==$request->user->id){//如果是所有者邮寄给借出人
            $data=['status'=>1,'auditor_send_time'=>time(),
                'express_group'=>$request->input('kdgs')
                ,'express_address'=>$request->input('express_address')
            ];
            if (!empty($request->input('kddh'))){
                $data['express_num']=$request->input('kddh');
            }
            $record->where('status',0);
            $status=$record->update($data);
            if ($status){
                return ['status'=>1,'msg'=>'登记成功,请及时寄出'];
            }
        }elseif ($request->user->id==$insquery->record->openid){//如果是借出人还
            $data=['status'=>3,'auditor_back_time'=>time(),
                'back_express_group'=>$request->input('kdgs'),
                'back_address'=>$request->input('express_address')];
            if (!empty($request->input('kddh'))){
                $data['back_express_num']=$request->input('kddh');
            }
            $record->where('status',2);
            $status=$record->update($data);
            if ($status){
                return ['status'=>1,'msg'=>'登记成功,请及时寄出'];
            }
        }else{//都不是
            return ['status'=>0,'msg'=>'您不是此仪器的所有者或借用者'];
        }
        return ['status'=>0,'msg'=>'操作失败'];
    }

    public function accepting(Request $request)//仪器接收
    {
        $record=Record::where('instrument_id',$request->input('id'))->where('status','<',4)->first();
        if (!$record){return ['status'=>0,'msg'=>'无匹配状态仪器'];}
        $recordquery=Record::query();
        $recordquery->where('instrument_id',$request->input('id'));
        $recordquery->with('classify','version','instrument','user');
        if ($request->user->id==$record->openid){//借出人接收
            $recordquery->where('status',1);
            $res=$recordquery->first();
            if (!$res){
                return ['status'=>0,'msg'=>'无匹配状态仪器'];
            }
        }elseif($request->user->id==$record->have_id){//拥有者接收归还仪器
            $recordquery->where('status',3);
            $res=$recordquery->first();
            if (!$res){
                return ['status'=>0,'msg'=>'无匹配状态仪器'];
            }
            $res['express_num']=$res['back_express_num'];
            $res['express_group']=$res['back_express_group'];
            $res['name']=$res['user']['name'];
            $res['phone']=$res['back_tell'];
            $res['address']=$res['back_address'];
        }else{
            return ['status'=>0,'msg'=>'您无此仪器记录'];
        }
        return ['status'=>1,'res'=>$res];
    }
    public function accept(Request $request)//仪器接收逻辑
    {
        $record=Record::where('id',$request->input('id'))->where('status','<',4)->first();
        /*
         *拥有者接收归还仪器
         * 1.状态改成4 仪器归还给所有者
         * 2.仪器状态改成可借用
         */
        if($request->user->id==$record->have_id){
            Record::where('id',$request->input('id'))->update(['status'=>4,'auditor_send_accept_time'=>time()]);
            Instrument::where('id',$record['instrument_id'])->update(['borrow'=>1,'record_id'=>0]);
        }elseif ($request->user->id==$record->openid) {//借出人接收
            Record::where('id',$request->input('id'))->update(['status'=>2,'auditor_back_accept_time'=>time()]);
        }
        return ['status'=>1,'msg'=>'接收成功'];
    }

    public function localstock(Request $request)//本地库存
    {
        $localstock=LocalStock::query();
        $localstock->with('classify','version');
        if ($request->input('classify')>0){
            $localstock->where('classify_id',$request->input('classify'));
        }
        if ($request->input('version')>0){
            $localstock->where('version_id',$request->input('version'));
        }
        $res=$localstock->get();
        foreach ($res as $k=>$v){
            $res[$k]['img']=$_SERVER['HTTP_ORIGIN'].'/uploads/'.$v['img'];
        }
        $classify=Classify::select('id','title')->get();
        $classify=$this->change($classify,'title');
        $version=Version::select('id','title')->get();
        $version=$this->change($version,'title');
        return ['res'=>$res,'classify'=>$classify,'version'=>$version];
    }

    /**
     * @package test
     * @author 石头哥 sun@httproot.com
     * data:2017/11/30
     * @param unknown $
     * @return unknown
     */
    public static function test(){
        $records=Record::where('repay_time','<',time()+60*60*24*3)->where('auditor_status',1)
            ->where('status',2)->with('classify','version','borrowuser','haveuser')->get();
        foreach ($records as $v){
            $day=round(($v->repay_time-time())/3600/24);
            $url=getenv('APP_URL').'/wechat/audit.html';
            $array=[
                'first'=>'剩余'.$day.'天',
                'keyword1'=>/*$v->id.*/'类型:'.$v['classify'][0]['title'].' 型号:'.$v['version'][0]['title'],
                'keyword2'=>date('Y/m/d',$v->borrow_time),
                'keyword3'=>date('Y/m/d',$v->repay_time),
                'remark'=>'借用者:'.$v->name.' 电话:'.$v->phone,
            ];
            if ($day<=3){//小于3天 发送给借用者
                $openid=$v->borrowuser->openid;
                self::tmplmsg($openid,$url,$array);
            }
            if ($day<=1){//小于等于一天 发送给借用者和拥有者
                $openid=$v->haveuser->openid;
                self::tmplmsg($openid,$url,$array);
            }
        }
    }
    /**
     * @package 模板消息
     * @author 石头哥 sun@httproot.com
     * data:2017/11/30
     * @param unknown $
     * @return unknown
     */
    public static function tmplmsg($openid,$url,$array)
    {
        $murl="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".WxConfigController::getAccessToken();
        $data=[
            'touser'=>$openid,
            'template_id'=>"thLAaJOokPcpa1eU3FODCIAOnms2ng8mbN1ewaACphc",
            "url"=>$url,
//            "miniprogram"=>["appid"=>"xiaochengxuappid12345", "pagepath"=>"index?foo=bar"],
            "data"=>[]
        ];
        foreach ($array as $k=>$v){
            $data['data'][$k] = ["value"=>$v];
        }
        $res=Common::post_Data($murl,$data);
//        print_r($res);
    }
}
