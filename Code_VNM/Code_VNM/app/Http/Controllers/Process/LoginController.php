<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\UserModel;

class LoginController extends Controller{
    
    protected function getLogin (){
        
        if (session()->has('user')) {
            return redirect('/Admin/drinks/all');
        } else {
            return view('login');
        }
    }
    
    
    protected function postLogin(Request $request){
        $username = $request->txtUsername;
        $password = md5($request->txtPassword);
        $users = UserModel::getUserByUsernamePassword($username, $password);
        if(count($users) > 0){
            session(['user' => $users[0]]);
            return redirect('/Admin/drinks/all');
        }else{
            return view('login', ['username' => $username,
                    'errMess' => 'Tên đăng nhập hoặc mật khẩu không đúng']);
        }
    }
    protected function getLoginMob(Request $request){
        $username = $request->txtUsername;
        $password = md5($request->txtPassword);
        $users = UserModel::getUserByUsernamePassword($username, $password);
        if(count($users) > 0){
            return $users;
        }else{
            return 'false';
        }
    }
    

        protected function getLogout(){
        session()->flush();
        return redirect('/login');
    }
}