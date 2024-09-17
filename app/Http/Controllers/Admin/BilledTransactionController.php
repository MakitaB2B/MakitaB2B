<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BilledTransactionService;
use Carbon\Carbon;
use App\Models\Admin\BilledTransaction;
use Illuminate\Support\Facades\DB;

class BilledTransactionController extends Controller
{
    protected $billedTransactionService;
    public function __construct(BilledTransactionService $billedTransactionService){
        $this->billedTransactionService=$billedTransactionService;
    }

    public function index(Request $request){

     $result=$this->billedTransactionService->getBilledTransactions();

    return view('Admin.billed_transactions',compact('result')); 

    }

    public function uploadBilledTransaction(Request $request){

        if (request()->has('mycsv')) {

        $data = array_map('str_getcsv', file(request()->mycsv));

        array_shift($data);

        $header = array_map('trim', array_shift($data));
           
            set_time_limit(0);
            $batchSize = 1000;
            $billedData = [];

            foreach ($data as $index => $row) {

            $billData = array_combine($header, $row);

            foreach ($billData as $key => $value) {
            
            if ($key === "Cust PO") {
                $fieldValue = explode('-', explode('|', $value)[0] ?? $value);
                $consistentRecord["order_id"] = $fieldValue[1] ;
                $consistentRecord["promo_code"] = str_replace('PR', '', $fieldValue[0]); 
            } else {
 
                $consistentRecord[$key] = ($key == "Invoice Date") ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : ($key == "EXTENDED PRICE" ? intval(str_replace(',', '', $value)) : $value);
            }
     
            }

            $consistentRecord['billed_transaction_slug'] =  $this->billedTransactionService->billed_transaction_slug();
            $billedData[] = $consistentRecord;
           
            if (count($billedData) >= $batchSize) {
       
                BilledTransaction::insert($billedData);
               
                $billedData= []; 
            }
        
        }
           
        if (!empty($billedData)) {
            BilledTransaction::insert($billedData);
        }

        $changedstatus = $this->changeStatusToBilled();

        return redirect('admin/billed-transactions');
      }


    }

    public function changeStatusToBilled(Request $request){

        DB::table('transactions as t')
        ->join(DB::raw('(SELECT order_id,Item, SUM(Qty Invoiced) as total_qty FROM billed_transactions GROUP BY order_id, model_no) as bt'), function ($join) {
            $join->on('t.order_id', '=', 'bt.order_id')
                 ->on('t.model_no', '=', 'bt.Item')
                 ->on('t.promo_code', '=', 'bt.promo_code')
                 ;
        })
        ->where(function ($query) {
            $query->whereColumn('t.order_qty', 'bt.total_qty')
                  ->orWhere('bt.created_at', '<', now()->subDays(7));
        })
        ->update([
            't.status' => DB::raw("
                CASE 
                    WHEN t.order_qty = bt.total_qty THEN 'billed'
                    WHEN t.created_at < NOW() - INTERVAL 7 DAY THEN 'cancelled'
                    ELSE t.status
                END
            ")
        ]);
    

    }    
}
