<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\PayloadFactory;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{
    public function authenticate(Request $request)
    {
        //取消此token
//        JWTAuth::refresh($token);
        //设置token值
//        JWTAuth::setToken('foo.bar.baz');
//        Validator
    }

    /**
     * @package gettoken
     * @author 石头哥 sun@httproot.com
     * data:2017/11/17
     * @param unknown $
     * @return unknown
     */
    public function getToken(Request $request){
        //通过用户对象实例创建token
        $user = User::first();
        $token = JWTAuth::fromUser($user);
        return $token;
    }

    /**
     * @package 取消此token
     * @author 石头哥 sun@httproot.com
     * data:2017/11/17
     * @param unknown $
     * @return unknown
     */
    public function refreshToken($token){
        //取消此token
        JWTAuth::refresh($token);
    }

    //从Token中获取认证用户：
    public function tokenGetUser()
    {
//        $token = JWTAuth::getToken();
//        print_r(JWTAuth::toUser($token));
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }
}
