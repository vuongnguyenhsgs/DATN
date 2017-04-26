<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;
use Exception;

class DrinkModel {

    public static function getAll() {
        return DB::table('drinks')
                        ->join('categories', 'drinks.category_id', '=', 'categories.id')
                        ->select('drinks.id', 'drinks.name', 'drinks.category_id', 'categories.name as category_name', 'drinks.price')
                        ->where([
                            ['drinks.deleted_flag', '=', 0]
                        ])->get();
    }

    public static function getDrinkByName($name) {
        return DB::table('drinks')->select('id')
                        ->where('name', '=', $name)->get();
    }
    
    public static function getDrinkById($id) {
        return DB::table('drinks')->select('id','name','category_id','image1','price','description')
                        ->where('id', '=', $id)->get();
    }


    public static function isExistedCategory($categoryName) {
        $categories = DB::table('categories')->select('id', 'name')
                        ->where('name', '=', $categoryName)->get();
        if (count($categories) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function getCategoryByName($categoryName) {
        $categories = DB::table('categories')->select('id', 'name')
                        ->where('name', '=', $categoryName)->get();
    }

    public static function addCategory($data) {
        try {
            return DB::table('categories')->insertGetId([
                        'name' => $data['txtCategoryName']
            ]);
        } catch (Exception $ex) {
            return 0;
        }
    }
    
    public static function postDelDrink($drinkId){
        try{
            return DB::table('drinks')->where('id','=',$drinkId)->update(['deleted_flag' => 1]);
        } catch (Exception $ex) {
            return false;
        }
    }

}
