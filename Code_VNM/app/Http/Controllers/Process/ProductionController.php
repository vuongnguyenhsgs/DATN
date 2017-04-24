<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\ProductionModel;

class ProductionController extends Controller{
    
    /**
     * Hiển thị danh sách toàn bộ nguyên liệu
     */
    protected function getAll(){
        $productions = ProductionModel::getAll();
        return view('Admin.Productions.all', compact(['productions']));
    }
    
    /**
     * Màn hình thêm mới
     */
    protected function getAdd(){
        return view('Admin.Productions.add');
    }
    
    protected function postDelProduction(Request $request){
        if(ProductionModel::postDelProduction($request->productionId)){
            return 'true';
        }else{
            return 'false';
        }
    }
}