<?php
namespace App\Services;
use App\Models\Admin\MobileExpense;

class MobileExpenseService{
  
    public function getMobileExpense($grade){
        return MobileExpense::where(['grade'=> $grade])->select('expense')->first();
    }
}
?>