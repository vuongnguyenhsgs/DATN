<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Models\CategoryModel;
use App\Http\Models\DrinkModel;
use Illuminate\Http\Request;

class ShopController extends Controller {

    protected function index() {
        $categories = CategoryModel::getAllCategory();
        $drinks = DrinkModel::getDrinkToHomePage();
        return view('Public.home', compact(['categories', 'drinks']));
    }

    protected function getDrinkByCategory($id) {
        $categories = CategoryModel::getAllCategory();
        $drinks = DrinkModel::getDrinkByCategory($id);
        return view('Public.home', compact(['categories', 'drinks']));
    }

    protected function getDrinkDetail($id) {
        $categories = CategoryModel::getAllCategory();
        $drinks = DrinkModel::getDrinkById($id);
        return view('Public.detail', compact(['categories', 'drinks']));
    }

    protected function postAddToBill(Request $request) {
        try {
            $items = \Cart::get($request->txtDrinkId);
            if(count($items) > 0){
                \Cart::update($request->txtDrinkId, array(
                    'quantity' => ($request->txtQuantity),
                ));
            }else{
                \Cart::add($request->txtDrinkId,$request->txtDrinkName,$request->txtPrice,$request->txtQuantity,
                        array('image1' => $request->image1));
            }
            return 'true';
        } catch (Exception $ex) {
            return 'false';
        }
    }
    
    protected function getCart(){
        $categories = CategoryModel::getAllCategory();
        $cartItems = \Cart::getContent();
        return view('Public.cart', compact(['categories','cartItems']));
    }
    
    

}
