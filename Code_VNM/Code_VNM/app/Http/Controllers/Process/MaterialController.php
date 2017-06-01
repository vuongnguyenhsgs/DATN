<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\MaterialModel;
use App\Http\Models\ProductionModel;

class MaterialController extends Controller{
    
    /**
     * Hiển thị danh sách toàn bộ nguyên liệu
     */
    protected function getAll(){
        $materials = MaterialModel::getAll();
        return view('Admin.Materials.all', compact(['materials']));
    }
    
    /**
     * Màn hình thêm mới
     */
    protected function getAdd(){
        $type = 'add';
        $productions = ProductionModel::getAll();
        return view('Admin.Materials.add', compact(['type','productions']));
    }
    
    protected function postDelMaterial(Request $request){
        if(MaterialModel::postDelMaterial($request->materialId)){
            return 'true';
        }else{
            return 'false';
        }
    }
    
    protected function isExistedMaterial(Request $request){
        $materials = MaterialModel::getMaterialByName($request->txtMaterialName);
        if(count($materials) > 0){
            return 'true';
        }else{
            return 'false';
        }
    }
    
    protected function postAddMaterial(Request $request){
        $data = $request->except('_token');
        if(MaterialModel::postAddMaterial($data)){
            return 'true';
        }else{
            return 'false';
        }
    }
}