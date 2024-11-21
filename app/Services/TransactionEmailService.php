<?php
namespace App\Services;
use App\Models\Admin\TransactionEmail;
use Exception;

class TransactionEmailService{

    public function getTransactionDetails($transactionEmailService){

        return TransactionEmail::with(['sales_name:employee_slug,full_name,employee_no'])->where('rm_slug',$transactionEmailService)->select('region','sales_slug')->get();
    }

    public function getEmailId($sales_slug){
        return TransactionEmail::where('sales_slug',$sales_slug)->value('mail_id');
    }

}
?>
