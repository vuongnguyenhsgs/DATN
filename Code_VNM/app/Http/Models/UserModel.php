<?php

    namespace App\Http\Models;
    
    use Illuminate\Support\Facades\DB;
    
    class UserModel{
        public static function getUserByUsernamePassword($username, $password){
            $users = DB::table('employees')->select('id','username','fullname','address','phone','birthday','identity_no'
                    ,'salary','subvention','role')
                    ->where([
                        ['username', '=', $username],
                        ['password', '=', $password]
                    ])->get();
            return $users;
        }
        
        public static function getAll(){
            $users = DB::table('employees')->select('id','username','fullname','address','phone','birthday','identity_no'
                    ,'salary','subvention','role')
                    ->where([
                        ['deleted_flag', '=', 0],
                    ])->get();
            return $users;
        }
    }