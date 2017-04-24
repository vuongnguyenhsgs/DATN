<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class MaterialModel {
    
    public static function getAll(){
        return DB::table('materials')
                ->leftJoin('productions','productions.id','=','materials.production_id')
                ->select('materials.id','materials.name','materials.quantity',
                        'materials.price','productions.name as production_name' )
                ->where('materials.deleted_flag','=','0')->get();
    }
    
    public static function postDelMaterial($materialId){
        try{
            return DB::table('materials')->where('id','=',$materialId)->update(['deleted_flag' => 1]);
        } catch (Exception $ex) {
            return false;
        }
    }
}