<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\DrinkModel;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Models\BillModel;

class BillController extends Controller {

    protected function getBill(Request $request) {
        if(!$request->has('status')){
            $status = 0;
        }else{
            $status = $request->status;
        }
        if(!$request->has('startDate')){
            $startDate = NULL;
        }else{
            $startDate = $request->startDate . '00:00:00';
        }
        if(!$request->has('endDate')){
            $endDate = NULL;
        }else{
            $endDate = $request->endDate . '00:00:00';  
        }
        $bills = BillModel::getBill($status,$startDate,$endDate);
        return view('Admin.Bills.all', compact(['bills','status','startDate','endDate']));
    }

    protected function getAddBill() {
        $type = 'add';
        $drinks = DrinkModel::getAll();
        return view('Admin.Bills.add', compact(['type', 'drinks']));
    }

    protected function postAddBill(Request $request) {
        try {
            DB::beginTransaction();
            $bill = array(
                'txtCustomerName' => $request->txtCustomerName,
                'txtCustomerPhone' => $request->txtPhone,
                'txtCustomerAddress' => $request->txtAddress,
                'total' => $request->total
            );
            $billId = BillModel::addNewBill($bill);
            $arrBillDetails = explode(',', $request->billDetail);
            for ($i = 0; $i < count($arrBillDetails); $i++) {
                if ($arrBillDetails[$i] != '') {
                    $billDetail = explode('-', $arrBillDetails[$i]);
                    BillModel::addNewBillDetail(array(
                        'bill_id' => $billId,
                        'drink_id' => $billDetail[0],
                        'quantity' => $billDetail[1],
                        'price' => $billDetail[2],
                    ));
                }
            }
            DB::commit();
            return 'true';
        } catch (Exception $ex) {
            DB::rollBack();
            return 'false';
        }
    }

}
