<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\CategoryModel;
use App\Http\Models\DrinkModel;
use Illuminate\Support\Facades\DB;

class DrinkController extends Controller {

    /**
     * Danh sách toàn bộ đồ uống
     */
    protected function getAll() {
        $drinks = DrinkModel::getAll();
        return view('Admin.Drinks.all', compact(['drinks']));
    }

    /**
     * Danh sách toàn bộ đồ uống mobile
     */
    protected function mobGetAll() {
        return DrinkModel::getAll();
    }

    /**
     * Kiểm tra đồ uống đã tồn tại chưa
     * @return 'true': đã tồn tại
     * @return 'false': chưa tồn tại
     */
    protected function isExistedDrink(Request $request) {
        //Kiểm tra theo tên
        if ($request->typeCheck == 'name') {
            $drinks = DrinkModel::getDrinkByName($request->txtDrinkName);
            if (count($drinks) > 0) {
                return 'true';
            } else {
                return 'false';
            }
        } else {
            //Kiểm tra theo id
            $drinks = DrinkModel::getDrinkById($request->drinkId);
            if (count($drinks) > 0) {
                return 'true';
            } else {
                return 'false';
            }
        }
    }

    /**
     * Kiểm tra tên loại đồ uống đã tồn tại chưa
     * @return 'true': đã tồn tại
     * @retun 'false': chưa tồn tại
     */
    protected function isExistedCategory(Request $request) {
        if (DrinkModel::isExistedCategory($request->txtCategoryName)) {
            return 'true';
        } else {
            return 'false';
        }
    }

    /**
     * Xử lý thêm loại đồ uống
     * @return 'existed': Loại đồ uống đã tồn tại
     * @return id của loại đồ uống nếu thêm thành công
     */
    protected function addCategory(Request $request) {
        if (DrinkModel::isExistedCategory($request->txtCategoryName)) {
            return 'existed';
        }
        return DrinkModel::addCategory($request->except('_token'));
    }

    protected function getAdd() {
        $type = 'add';
        $categories = CategoryModel::getAllCategory();
        return view('Admin.Drinks.add', compact(['type', 'categories']));
    }

    protected function postAdd(Request $request) {
        try {
            $image = '';
            if ($request->hasFile('drinkImageInput') && $request->file('drinkImageInput')->isValid()) {
                $file = $request->file('drinkImageInput');
                $name = $file->getClientOriginalName();
                $name .= date("y_m_d_h_i_sa");
                $name .= random_int(1, 99999) . '.' . $file->extension();
                $image .= $name;
                $file->storeAs('/public/images/drinks', $image);
            }
            if ($request->type == 'add') {
                DB::table('drinks')->insert([
                    'name' => $request->txtDrinkName,
                    'category_id' => $request->cobCategory,
                    'image1' => $image,
                    'price' => str_replace(',', '', $request->txtPrice),
                    'description' => $request->txtDescription,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time())
                ]);
            } else {
                DB::table('drinks')->where('id','=',$request->drinkId)->update([
                    'name' => $request->txtDrinkName,
                    'category_id' => $request->cobCategory,
                    'price' => str_replace(',', '', $request->txtPrice),
                    'description' => $request->txtDescription,
                    'updated_at' => date('Y-m-d H:i:s', time())]);
                if($image != ''){
                    DB::table('drinks')->where('id','=',$request->drinkId)->update([
                        'image1' => $image
                    ]);
                }
            }
            return redirect('/Admin/drinks/all');
        } catch (Exception $ex) {
            return redirect('/Admin/drinks/all');
        }
    }

    /**
     * Xóa đồ uống
     * @return 'true' nếu xóa thành công
     * @return 'false' nếu xóa không thành công
     */
    protected function postDelDrink(Request $request) {

        if (DrinkModel::postDelDrink($request->drinkId)) {
            return 'true';
        } else {
            return 'false';
        }
    }

    //Xử lý thao tác sửa thông tin đồ uống
    protected function getEditDrink($drinkId) {
        //Kiểm tra còn tồn tại hay không
        $drinks = DrinkModel::getDrinkById($drinkId);
        if (count($drinks) == 0) {
            $messContent = 'Sản phẩm này đã bị xóa hoặc không tồn tại';
            $urlBack = '/Admin/drinks/all';
            return view('Admin.Errors.error', compact(['messContent', 'urlBack']));
        } else {
            $categories = CategoryModel::getAllCategory();
            $type = 'edit';
            return view('Admin.Drinks.add', compact(['drinks', 'type', 'categories']));
        }
    }

}
