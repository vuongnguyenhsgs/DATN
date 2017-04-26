<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillController extends Controller {

    protected function getBill(Request $request) {
        
    }

    protected function getAddBill() {
        return view('Admin.Bills.add');
    }

}
