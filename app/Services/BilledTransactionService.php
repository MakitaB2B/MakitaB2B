<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\Transaction;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Admin\BilledTransaction;
class BilledTransactionService{

    public function billed_transaction_slug(){
   
        return Str::slug(rand().rand());
    }

    public function getBilledTransactions(){

        return BilledTransaction::orderBy('create_date','desc')->paginate(20,['Invoice','Name','Invoice Date','order_id','promo_code','Order','Item','Description','Qty Invoiced','Price','create_date','updated_at']);  //,'commercial_status',
   
    }

}
?>
