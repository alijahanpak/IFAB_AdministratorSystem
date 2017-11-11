<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Modules\Admin\Entities\Season;
use Modules\Admin\Entities\User;
use Modules\Budget\Entities\CreditDistributionTitle;

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
        $userInfo = User::where('email' , '=' , $request->email)->first();
        $http = new \GuzzleHttp\Client;
        if ($userInfo && Hash::check($request->password , $userInfo->password))
        {
            $response = $http->post(url('/oauth/token'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => env('PASSWORD_CLIENT_ID'),
                    'client_secret' => env('PASSWORD_CLIENT_SECRET'),
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope' => '',
                ],
            ]);
            return json_decode((string) $response->getBody(), true);
        }
        else{
            return \response()->json([], 401);
        }
    }

    public function userIsAuthorize(Request $request)
    {
        return \response()->json([] , 200);
    }
}
