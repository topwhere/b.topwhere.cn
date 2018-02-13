<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Menu;

class AdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()&&Auth::user()->type=='admin'){
//            $this->menus($request);
            return $next($request);
        }else{
            return redirect(route('admin.login'));
        }

    }
    public $fpa='';
    public function menus($request)
    {
        $did='';
//        $url=$request->getRequestUri();
        $url= Route::currentRouteName();
        try {
            $menu = Menu::all();
            foreach ($menu as $v) {
                if ($v->pid != 0 && $v->url == $url) {
                    $did = $v;
                    $fpa = $this->fpand($menu, $v->pid);
                }
            }
            return view()->share(['did' => $did, 'fpa' => $this->fpa]);

        }catch (\Exception $e){

        }
    }

    public function fpand($menu,$pid)
    {
        foreach ($menu as $v){
            if ($v->pid!=0&&$v->id==$pid){
                $this->fpand($menu,$v->pid);
            }
            if($v->pid==0&&$v->id==$pid){
                return $this->fpa=$v->id;
            }
        }
    }
}
