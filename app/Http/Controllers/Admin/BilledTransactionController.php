<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BilledTransactionService;
use Carbon\Carbon;
use App\Models\Admin\BilledTransaction;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Transaction;

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

    // public function uploadBilledTransaction(Request $request){

    //     $validator = \Validator::make(request()->all(), [
    //         'mycsv' =>'required|file|mimes:csv,txt|max:2048',
    //     ]);
        
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator->errors());
    //     }

    //     if (request()->has('mycsv')) {

    //     $data = array_map('str_getcsv', file(request()->mycsv));

    //     array_shift($data);
    //     DB::transaction(function () use($data) {
    //     $header = array_map('trim', array_shift($data));
           
    //         set_time_limit(0);
    //         $batchSize = 1000;
    //         $billedData = [];

    //         foreach ($data as $index => $row) {

    //         $billData = array_combine($header, $row);

    //         foreach ($billData as $key => $value) {
            
    //         if ($key === "Cust PO") {
    //             $fieldValue = explode('-', explode('|', $value)[0] ?? $value);
    //             $consistentRecord["order_id"] = $fieldValue[1] ;
    //             $consistentRecord["promo_code"] = str_replace('PR', '', $fieldValue[0]); 
    //         } else {
 
    //             $consistentRecord[$key] = ($key == "Invoice Date") ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : ($key == "EXTENDED PRICE" ? intval(str_replace(',', '', $value)) : $value);

    //         }
     
    //         }

    //         $consistentRecord['billed_transaction_slug'] =  $this->billedTransactionService->billed_transaction_slug();
    //         $billedData[] = $consistentRecord;
           
    //         if (count($billedData) >= $batchSize) {
               
    //             BilledTransaction::insert($billedData);
               
    //             $billedData= []; 
    //         }
        
    //     }
           
    //     if (!empty($billedData)) {
    //         BilledTransaction::insert($billedData);
    //     }

    //     $changedstatus = $this->changeStatusToBilled();
    //     }); 
    //     return redirect('admin/billed-transactions');
    //   }
   
    // }

    public function uploadBilledTransaction(Request $request)
    {
  
    $validator = \Validator::make(request()->all(), [
        'mycsv' => 'required|file|mimes:csv,txt',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator->errors());
    }

    if (request()->has('mycsv')) {

        $data = array_map('str_getcsv', file(request()->mycsv));
        // array_shift($data); 
      
        $tableColumns = \Schema::getColumnListing('billed_transactions');
       
        DB::transaction(function () use($data, $tableColumns) {
            $header = array_map('trim', array_shift($data)); 
            $batchSize = 1000;
            $billedData = [];
            $pattern = '/PR\d{3}-\w{1,10}\|/';  //'/PR\d{3}-\w{10}\|/';
            set_time_limit(0); // Prevent timeout

            foreach ($data as $index => $row) {
                $billData = array_combine($header, $row);
                $consistentRecord = [];
                
                if (!isset($billData['Cust PO']) || !preg_match($pattern, $billData['Cust PO'])) {
                    continue;
                }
               
            foreach($billData as $key => $value){    //foreach ($billData as $key => $value) {
                    if ($key === "Cust PO") {
                        $fieldValue = explode('-', explode('|', $value)[0] ?? $value);
                        
                        $consistentRecord["order_id"] = $fieldValue[1];
                        $consistentRecord["promo_code"] = str_replace('PR', '', $fieldValue[0]);
                    } elseif (in_array($key, $tableColumns)) {
                        // Only add the key if it exists in the table columns
                        $consistentRecord[$key] = ($key == "Invoice Date") 
                            ? Carbon::parse($value)->format('Y-m-d')         //Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') 
                            : (strtolower($value) == "extended price" ? intval(str_replace(',', '', $value)) : $value);
                    }
                }

                // Add any additional required fields
                $consistentRecord['billed_transaction_slug'] = $this->billedTransactionService->billed_transaction_slug();
                $consistentRecord['create_date'] = date('Y-m-d H:i:s');
                $billedData[] = $consistentRecord;
                // Step 7: Insert data in batches to optimize performance
                if (count($billedData) >= $batchSize) {
                    BilledTransaction::insert($billedData);
                    $billedData = [];
                }
            }
           
            // Step 8: Insert remaining data if any
            if (!empty($billedData)) {
                try {
                    // $databaseName = \DB::connection()->getDatabaseName();
                    // dd($databaseName);
                    // dump($billedData);
                    // BilledTransaction::insert($billedData);
                    BilledTransaction::insert([
                        "Invoice" => "KA2425G15451",
                        "billed_transaction_slug" => "56056133538002096",
                        "Name" => "M TRADERS",
                        "Planner Code" => "M",
                      ]);



                    //   "Site" => "MAKITA",
                    //   "Customer" => "27-0079",
                    //   "Name" => "M TRADERS",
                    //   "Invoice Date" => "2025-01-15",
                    //   "order_id" => "1895492688",
                    //   "promo_code" => "850",
                    //   "Salesperson" => "MIN-429",
                    //   "Total Price" => "0",
                    //   "Order" => "24COFO3142",
                    //   "Item" => "DF488D002",
                    //   "Description" => "18V DRIVER DRILL BL1815GX2 DC18WB",
                    //   "Qty Invoiced" => "1",
                    //   "Price" => "0",
                    //   "Extended Price" => "0",
                    //   "Planner Code" => "M",
                    //   "billed_transaction_slug" => "56056133538002096",
                    //   "create_date" => "2025-01-21 17:09:28"
                    echo "Data inserted successfully!";
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
                // dd(DB::getQueryLog());
                  echo die();
            }
      
            // Change status to billed after successful insertion
            $this->changeStatusToBilled();
        });
   
        // Redirect to the billed transactions page
        return redirect('admin/billed-transactions');
    }
   }


    public function changeStatusToBilled(){

            
        // DB::enableQueryLog();

        //-----------built query

        // $start_date = now()->subDays(7)->toDateString();
        // $end_date = now()->toDateString();

        // $billedTransactionQuery = Transaction::join('billed_transactions', function($join) {
        //     $join->on('billed_transactions.order_id', '=', 'transactions.order_id')
        //          ->on('billed_transactions.Item', '=', 'transactions.model_no')
        //          ->on('billed_transactions.promo_code', '=', 'transactions.promo_code');
        // })
        // ->select(
        //     'billed_transactions.order_id', 
        //     'billed_transactions.Item',
        //     'billed_transactions.created_at', 
        //     DB::raw('SUM(billed_transactions.`Qty Invoiced`) AS total_qty') // Use DB::raw for aggregate functions
        // )
        // ->groupBy(
        //     'billed_transactions.order_id', 
        //     'billed_transactions.Item',
        //     'billed_transactions.created_at'
        // )
        // ->whereBetween('billed_transactions.created_at', [ $start_date, $end_date])
        // ->update([
        //     'transactions.status' => DB::raw("
        //         CASE 
        //             WHEN transactions.order_qty = total_qty THEN 'billed'
        //             WHEN transactions.created_at < NOW() - INTERVAL 7 DAY THEN 'cancelled'
        //             ELSE transactions.status
        //         END
        //     "),
          
        //     'transactions.billed_qty' => DB::raw("
        //         CASE
        //             WHEN transactions.order_qty != total_qty THEN total_qty
        //             ELSE total_qty
        //         END
        //     ")
        // ]);
        // ->get();
    
       //-----------built query 
       //-----------working code
        // $start_date = now()->subDays(7)->toDateString();
        // $end_date = now()->toDateString();
        
        // Transaction::join('billed_transactions', function($join) {
        //     $join->on('billed_transactions.order_id', '=', 'transactions.order_id')
        //          ->on('billed_transactions.Item', '=', 'transactions.model_no')
        //          ->on('billed_transactions.promo_code', '=', 'transactions.promo_code');
        // })
        // ->whereBetween('billed_transactions.created_at', [$start_date, $end_date])
        // ->update([
        //     'transactions.status' => DB::raw("
        //         CASE 
        //             WHEN transactions.order_qty = (
        //                 SELECT SUM(bt.`Qty Invoiced`) 
        //                 FROM billed_transactions as bt 
        //                 WHERE bt.order_id = transactions.order_id 
        //                 AND bt.Item = transactions.model_no 
        //                 AND bt.promo_code = transactions.promo_code
        //             ) THEN 'billed'
        //             WHEN transactions.created_at < NOW() - INTERVAL 7 DAY THEN 'cancelled'
        //             ELSE transactions.status
        //         END
        //     "),
          
        //     'transactions.billed_qty' => DB::raw("
        //         CASE
        //             WHEN transactions.order_qty != (
        //                 SELECT SUM(bt.`Qty Invoiced`) 
        //                 FROM billed_transactions as bt 
        //                 WHERE bt.order_id = transactions.order_id 
        //                 AND bt.Item = transactions.model_no 
        //                 AND bt.promo_code = transactions.promo_code
        //             ) THEN (
        //                 SELECT SUM(bt.`Qty Invoiced`) 
        //                 FROM billed_transactions as bt 
        //                 WHERE bt.order_id = transactions.order_id 
        //                 AND bt.Item = transactions.model_no 
        //                 AND bt.promo_code = transactions.promo_code
        //             )
        //             ELSE (
        //                 SELECT SUM(bt.`Qty Invoiced`) 
        //                 FROM billed_transactions as bt 
        //                 WHERE bt.order_id = transactions.order_id 
        //                 AND bt.Item = transactions.model_no 
        //                 AND bt.promo_code = transactions.promo_code
        //             )
        //         END
        //     ")
        // ]);

       //-----------working code
       DB::enableQueryLog();
        $start_date = now()->subDays(15)->toDateString();
        $end_date = now()->addDay()->toDateString();

        Transaction::join('billed_transactions', function($join) {
            $join->on('billed_transactions.order_id', '=', 'transactions.order_id')
                 ->on('billed_transactions.Item', '=', 'transactions.model_no')
                 ->on('billed_transactions.promo_code', '=', 'transactions.promo_code');
        })
        ->whereBetween('billed_transactions.create_date', [$start_date, $end_date])
        ->update([
            'transactions.billed_qty' => DB::raw("
                CASE
                    WHEN transactions.order_qty != (
                        SELECT SUM(bt.`Qty Invoiced`) 
                        FROM billed_transactions as bt 
                        WHERE bt.order_id = transactions.order_id 
                        AND bt.Item = transactions.model_no 
                        AND bt.promo_code = transactions.promo_code
                        AND bt.price = transactions.offer_price
                        AND bt.`Extended Price` = transactions.order_price
                    ) THEN (
                        SELECT SUM(bt.`Qty Invoiced`) 
                        FROM billed_transactions as bt 
                        WHERE bt.order_id = transactions.order_id 
                        AND bt.Item = transactions.model_no 
                        AND bt.promo_code = transactions.promo_code
                        AND bt.`Price` = transactions.offer_price
                        AND bt.`Extended Price` = transactions.order_price
                    )
                    ELSE (
                        SELECT SUM(bt.`Qty Invoiced`) 
                        FROM billed_transactions as bt 
                        WHERE bt.order_id = transactions.order_id 
                        AND bt.Item = transactions.model_no 
                        AND bt.promo_code = transactions.promo_code
                        AND bt.`Price` = transactions.offer_price
                        AND bt.`Extended Price` = transactions.order_price
                    )
                END
            "),
            'transactions.status' => DB::raw("
                CASE 
                    WHEN transactions.order_qty = (
                        SELECT SUM(bt.`Qty Invoiced`) 
                        FROM billed_transactions as bt 
                        WHERE bt.order_id = transactions.order_id 
                        AND bt.Item = transactions.model_no 
                        AND bt.promo_code = transactions.promo_code
                        AND bt.`Price` = transactions.offer_price
                        AND bt.`Extended Price` = transactions.order_price
                    ) THEN 'billed'
                    WHEN transactions.order_date < NOW() - INTERVAL 5 DAY 
                        AND transactions.billed_qty IS NULL THEN 'cancel'
                    ELSE transactions.status
                END
            ")
        ]);
        
        

    //  dd(DB::getQueryLog());
    
    }    
}
