<?php

    namespace App\Http\Models;
    
    use Illuminate\Support\Facades\DB;
    
    class UserModel{
        public static function getUserByUsernamePassword($username, $password){
            $users = DB::table('users')->select('username')
                    ->where([
                        ['username', '=', $username],
                        ['password', '=', $password]
                    ])->get();
            return $users;
        }
    }