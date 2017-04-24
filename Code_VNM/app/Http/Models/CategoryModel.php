<?php

    namespace App\Http\Models;
    
    use Illuminate\Support\Facades\DB;
    
    class CategoryModel {
        
        public static function getAllCategory(){
            return DB::table('categories')->select('id','name')->get();
        }
    }

