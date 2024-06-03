<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\DailySales;

class DailySalesController extends Controller
{
    public function index(){
        $result=DailySales::paginate(20,['date','fy','year','customer_name','wh_branch','region','state','sales_qty','unit_cost','sales_value','invoice_no','category_type','customer_order_number']);
        return view('Admin.daily_sales',compact('result'));
    }
    public function uploadDailySalesReport() {
        if(request()->has('dailysalesreport')){
            $data=array_map('str_getcsv', file(request()->dailysalesreport));
            $header=$data[0];
            unset($data[0]);
            DailySales::truncate();
            foreach ($data as $value) {
                set_time_limit(0);
                // dd(array_combine($header,$value));
                $stockData=array_combine($header,$value);
                DailySales::create($stockData);
            }
            return redirect('admin/daily-sales');
        }else{
            return 'No File not there';
        }
    }
}
