<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\Transaction;
use Illuminate\Support\Facades\DB;
use Exception;

class BilledTransactionService{

    public function billed_transaction_slug(){
   
        return Str::slug(rand().rand());
    }

}
?>
