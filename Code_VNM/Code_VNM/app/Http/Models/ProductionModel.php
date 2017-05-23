<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class ProductionModel {
    
    public static function getAll(){
        return DB::table('productions')
                ->select('id','name','address','phone')
                ->where('deleted_flag','=','0')->get();
    }
    
    public static function postDelProduction($productionId){
        try{
            return DB::table('productions')->where('id','=',$productionId)->update(['deleted_flag' => 1]);
        } catch (Exception $ex) {
            return false;
        }
    }
}