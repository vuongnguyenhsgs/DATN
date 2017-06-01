<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use App\Http\Models\BillModel;
use App\Http\Models\DrinkModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function view;
use DateTime;

class BillController extends Controller {

    protected function getBill(Request $request) {
        if(!$request->has('status')){
            $status = 0;
        }else{
            $status = $request->status;
        }
        if(!$request->has('txtStartDate')){
            $startDate = NULL;
        }else{
            $arrDate = explode('/', $request->txtStartDate);
            $startDate = date_format(new DateTime($arrDate[2].'-'.$arrDate[1].'-'.$arrDate[0]), 'Y-m-d').' 00:00:00';
        }
        if(!$request->has('txtEndDate')){
            $endDate = NULL;
        }else{
            $arrDate = explode('/', $request->txtEndDate);
            $endDate = date_format(new DateTime($arrDate[2].'-'.$arrDate[1].'-'.$arrDate[0]), 'Y-m-d').' 23:59:59'; 
        }
        $bills = BillModel::getBill($status,$startDate,$endDate);
        $employees = DB::table('employees')->select('id','fullname')->get();
        
        return view('Admin.Bills.all', compact(['bills','status','startDate','endDate','employees']));
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
                'total' => $request->total,
                'employee_id' => $request->employee_id,
                'status' => 1,
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
    
    protected function postAddBillMob(Request $request) {
        try {
            DB::beginTransaction();
            $bill = array(
                'txtCustomerName' => $request->txtCustomerName,
                'txtCustomerPhone' => $request->txtPhone,
                'txtCustomerAddress' => $request->txtAddress,
                'total' => $request->total,
                'employee_id' => $request->employee_id,
                'status' => 5,
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
            return $billId;
        } catch (Exception $ex) {
            DB::rollBack();
            return $ex;
        }
    }
    
    protected function getBillById($id){
        try{
            return BillModel::getBillById($id);
        } catch (Exception $ex) {
            return $ex;
        }
        
    }
    
    protected function getBillDetail(Request $request){
        return BillModel::getBillDetail($request->billId);
    }
    
    protected function getBillByStatus(Request $request){
        return BillModel::getBillByStatus($request->status);
    }
    
    protected function updateBillStatus(Request $request){
        try{
            BillModel::updateBillStatus($request->billId, $request->status, $request->employee_id);
            return 'true';
        } catch (Exception $ex) {
            return $ex;
        }
    }
    
    protected function deleteBill(Request $request){
        try{
            if(BillModel::deleteBill($request->drinkId)){
                return 'true';
            }else{
                return 'false';
            }
            
        } catch (Exception $ex) {
            return 'false';
        }
    }
    
    protected function getEditBill($id){
        $bills = BillModel::getBillById($id);
        $billDetails = BillModel::getBillDetail($id);
        return view('Admin.Bills.edit', compact(['bills','billDetails']));
    }
    
    protected function getAllTable(){
        return DB::table('tables')->select('name','status')->get();
    }
    
    protected function updateStatusTable(Request $request){
        try {
            DB::table('tables')->where('name','=',$request->name)
                    ->update(['status'=>$request->status]);
            return 'true';
        } catch (Exception $ex) {
            return 'false';
        }
    }
    
    protected function getStatistic(Request $request){
        if(!$request->has('status')){
            $status = 0;
        }else{
            $status = $request->status;
        }
        if(!$request->has('txtStartDate')){
            $startDate = NULL;
        }else{
            $arrDate = explode('/', $request->txtStartDate);
            $startDate = date_format(new DateTime($arrDate[2].'-'.$arrDate[1].'-'.$arrDate[0]), 'Y-m-d').' 00:00:00';
        }
        if(!$request->has('txtEndDate')){
            $endDate = NULL;
        }else{
            $arrDate = explode('/', $request->txtEndDate);
            $endDate = date_format(new DateTime($arrDate[2].'-'.$arrDate[1].'-'.$arrDate[0]), 'Y-m-d').' 23:59:59'; 
        }
        $result = array();
        $bills = BillModel::getBill($status, $startDate, $endDate);
        $totalBill = count($bills);
        array_push($result, $totalBill);
        $onl = 0;
        $total = 0;
        foreach($bills as $bill){
            if($bill->customer_phone == ''){
                $onl++;
            }
            $total += $bill->total;
        }
        array_push($result, $onl);
        array_push($result, $total);
        $drinks = BillModel::getStatistic($status, $startDate, $endDate);
        array_push($result, $drinks);
        return $result;
    }

}
