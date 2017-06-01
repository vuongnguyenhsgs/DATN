<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Models\CategoryModel;
use App\Http\Models\DrinkModel;
use Illuminate\Http\Request;
use App\Http\Models\BillModel;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller {

    protected function index() {
        $categories = CategoryModel::getAllCategory();
        $drinks = DrinkModel::getDrinkToHomePage();
        $cartQuantity = \Cart::getTotalQuantity();
        return view('Public.home', compact(['categories', 'drinks', 'cartQuantity']));
    }

    protected function getDrinkByCategory($id) {
        $categories = CategoryModel::getAllCategory();
        $drinks = DrinkModel::getDrinkByCategory($id);
        $cartQuantity = \Cart::getTotalQuantity();
        return view('Public.home', compact(['categories', 'drinks', 'cartQuantity']));
    }

    protected function getDrinkDetail($id) {
        $categories = CategoryModel::getAllCategory();
        $drinks = DrinkModel::getDrinkById($id);
        $cartQuantity = \Cart::getTotalQuantity();
        return view('Public.detail', compact(['categories', 'drinks', 'cartQuantity']));
    }

    protected function postAddToBill(Request $request) {
        try {
            $items = \Cart::get($request->txtDrinkId);
            if (count($items) > 0) {
                \Cart::update($request->txtDrinkId, array(
                    'quantity' => ($request->txtQuantity),
                ));
            } else {
                \Cart::add($request->txtDrinkId, $request->txtDrinkName, $request->txtPrice, $request->txtQuantity, array('image1' => $request->image1));
            }
            return 'true';
        } catch (Exception $ex) {
            return 'false';
        }
    }

    protected function getCart() {
        $categories = CategoryModel::getAllCategory();
        $cartItems = \Cart::getContent();
        $cartQuantity = \Cart::getTotalQuantity();
        return view('Public.cart', compact(['categories', 'cartItems', 'cartQuantity']));
    }

    protected function removeItemFromCart(Request $request) {
        try {
            \Cart::remove($request->itemId);
            return 'true';
        } catch (Exception $ex) {
            return 'false';
        }
    }

    protected function updateCart(Request $request) {
        try {
            $arrCartDetail = explode(',', $request->cartDetail);
            foreach ($arrCartDetail as $detail) {
                if ($detail != '') {
                    $arrDetail = explode('-', $detail);
                    \Cart::update($arrDetail[0], array(
                        'quantity' => array(
                            'relative' => false,
                            'value' => $arrDetail[1]
                        ),
                    ));
                }
            }
            return 'true';
        } catch (Exception $ex) {
            return 'false';
        }
    }

    protected function checkoutCart(Request $request) {
        try {
            //Cập nhật cart
            $arrCartDetail = explode(',', $request->cartDetail);
            foreach ($arrCartDetail as $detail) {
                if ($detail != '') {
                    $arrDetail = explode('-', $detail);
                    \Cart::update($arrDetail[0], array(
                        'quantity' => array(
                            'relative' => false,
                            'value' => $arrDetail[1]
                        ),
                    ));
                }
            }
            //Thêm hóa đơn
            DB::beginTransaction();
            $bill = array(
                'txtCustomerName' => $request->txtCustomerName,
                'txtCustomerPhone' => $request->txtPhone,
                'total' => \Cart::getTotal(),
                'employee_id' => $request->employee_id,
                'txtCustomerAddress' => $request->txtAddress,
                'status' => 0,
            );
            $billId = BillModel::addNewBill($bill);
            foreach (\Cart::getContent() as $item) {
                BillModel::addNewBillDetail(array(
                    'bill_id' => $billId,
                    'drink_id' => $item->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price
                ));
            }
            DB::commit();
            Cart::clear();
            return 'true';
        } catch (Exception $ex) {
            return 'false';
        }
    }

    protected function getDataSearch($keySearch) {
        return DrinkModel::getSearchDrink($keySearch);
    }

    protected function getPageSearch(Request $request) {
        $categories = CategoryModel::getAllCategory();
        $drinks = DrinkModel::getSearchDrinkPaginate($request->key);
        $cartQuantity = \Cart::getTotalQuantity();
        return view('Public.home', compact(['categories', 'drinks', 'cartQuantity']));
    }

}
