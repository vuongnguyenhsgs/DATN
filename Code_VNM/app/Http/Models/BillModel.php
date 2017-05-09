<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class BillModel{
    
    public static function getBill($status, $startDate, $endDate){
        try{
            return DB::select('CALL getBill(?,?,?)', array($status, $startDate, $startDate));
        } catch (Exception $ex) {
            return [];
        }
    }
    
    public static function addNewBill($arrData){
        return DB::table('bills')->insertGetId([
            'customer_name' => $arrData['txtCustomerName'],
            'customer_phone' => $arrData['txtCustomerPhone'],
            'customer_address' => $arrData['txtCustomerAddress'],
            'total' => $arrData['total'],
            'created_at' => date('Y-m-d H:i:s', time()),
            'status' => 0
        ]);
    }
    
    public static function addNewBillDetail($arrData){
        DB::table('bill_details')->insert([
            'bill_id' => $arrData['bill_id'],
            'drink_id' => $arrData['drink_id'],
            'quantity' => $arrData['quantity'],
            'price' => $arrData['price'],
        ]);
    }
    
}