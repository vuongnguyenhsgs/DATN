<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class MaterialModel {

    public static function getAll() {
        return DB::table('materials')
                        ->leftJoin('productions', 'productions.id', '=', 'materials.production_id')
                        ->select('materials.id', 'materials.name', 'materials.quantity', 'materials.price', 'productions.name as production_name')
                        ->where('materials.deleted_flag', '=', '0')->get();
    }

    public static function postDelMaterial($materialId) {
        try {
            return DB::table('materials')->where('id', '=', $materialId)->update(['deleted_flag' => 1]);
        } catch (Exception $ex) {
            return false;
        }
    }

    public static function getMaterialByName($materialName) {
        try {
            return DB::table('materials')
                            ->select('id', 'name', 'production_id', 'quantity', 'price')
                            ->where([
                                ['name', '=', $materialName],
                                ['deleted_flag', '=', '0']
                            ])->get();
        } catch (Exception $ex) {
            return [];
        }
    }

    public static function postAddMaterial($data) {
        return DB::table('materials')->insert([
                    'name' => $data['txtMaterialName'],
                    'production_id' => $data['cobProduction'],
                    'quantity' => str_replace(',', '', $data['txtQuantity']),
                    'price' => str_replace(',', '', $data['txtPrice']),
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time())
        ]);
    }

}
