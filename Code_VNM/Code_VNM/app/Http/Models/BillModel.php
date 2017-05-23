<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class BillModel {

    public static function getBill($status, $startDate, $endDate) {
        try {
            return DB::select('CALL getBill(?,?,?)', array($status, $startDate, $endDate));
        } catch (Exception $ex) {
            return [];
        }
    }

    public static function addNewBill($arrData) {
        return DB::table('bills')->insertGetId([
                    'customer_name' => $arrData['txtCustomerName'],
                    'customer_phone' => $arrData['txtCustomerPhone'],
                    'customer_address' => $arrData['txtCustomerAddress'],
                    'total' => $arrData['total'],
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'status' => $arrData['status'],
                    'employee_id' => $arrData['employee_id']
        ]);
    }

    public static function addNewBillDetail($arrData) {
        return DB::table('bill_details')->insert([
                    'bill_id' => $arrData['bill_id'],
                    'drink_id' => $arrData['drink_id'],
                    'quantity' => $arrData['quantity'],
                    'price' => $arrData['price'],
        ]);
    }

    public static function getBillById($id) {
        return DB::table('bills')->select('id', 'customer_name', 'customer_phone', 'customer_address', 'total', 'status', 'created_at', 'employee_id')
                        ->where([
                            ['id', '=', $id],
                            ['deleted_flag', '=', 0]
                        ])->get();
    }

    public static function getBillDetail($billId) {
        return DB::table('bill_details')
                        ->join('drinks', 'bill_details.drink_id', '=', 'drinks.id')
                        ->select('bill_details.id', 'bill_details.drink_id', 'bill_details.price', 'bill_details.quantity', 'drinks.name')
                        ->where('bill_details.bill_id', '=', $billId)->get();
    }
    
    public static function getBillByStatus($status){
        return DB::table('bills')->select('id', 'customer_name', 'customer_phone', 'customer_address', 'total', 'status', 'created_at','employee_id')
                        ->where([
                            ['deleted_flag', '=', 0],
                            ['status','=',$status]
                        ])->get(); 
    }
    
    public static function updateBillStatus($billId, $status, $employeeId){
        DB::table('bills')->where('id','=', $billId)
                ->update([
                    'status' => $status,
                    'employee_id' => $employeeId
                  ]);
    }
    
    public static function deleteBill($billId){
        return DB::table('bills')->where('id','=',$billId)
                ->update(['deleted_flag' => '1']);
    }
    
    public static function getStatistic($status, $startDate, $endDate){
        return DB::select('CALL getStatistic(?,?,?)', array($status, $startDate, $endDate));
    }
    
    
}
