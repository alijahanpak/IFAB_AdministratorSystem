<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function signin()
    {
        $validator = Validator::make(Input::all(), array() , array());
        if (Auth::attempt(['email' => Input::get('email') , 'password' => Input::get('password')] , false)) {
            return Redirect::to('/budget');
        } else {
            $validator->errors()->add('fail', 'نام کاربری یا کلمه عبور اشتباه است!');
            return Redirect::to('/login')
                ->withErrors($validator , 'loginErrors')
                ->withInput(Input::except('password'));
        }
    }

    public function signout()
    {
        Auth::logout();
        return Redirect::to('/login');
    }

    public function login_api(Request $request)
    {
        //$request->request->replace(is_array($data) ? $data : array());
        //echo dump($request) . "for test";
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], 200);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function getUserInfo(Request $request)
    {
        $user = Auth::user()->id;
        echo "morteza";
        //return \response()->json(Auth::user());
    }
}
