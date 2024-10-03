<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin\Transaction;
use App\Models\Admin\Employee;
use App\Mail\PromoTransactionFollowUpMail; // Make sure this line is included
use Mail;
use App\Services\EmployeeService;
class DailyPromoFollowUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:promo-follow-up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promo Follow Up Mail';

    /**
     * Execute the console command.
     */

    /**
     * The EmployeeService instance.
     *
     * @var EmployeeService
     */
    protected $employeeService;

    /**
     * Create a new command instance.
     *
     * @param EmployeeService $employeeService
     * @return void
     */

    public function __construct(EmployeeService $employeeService)
    {
        parent::__construct();
        $this->employeeService = $employeeService; // Assign service to class property
    }

    public function handle()
    {
        \Log::info('Daily Promo Follow-Up executed on ' . now()->toDateTimeString());
        
      $start_date = now()->subDays(7)->toDateString();
      $end_date = now()->toDateString();
    //--------------
    // $transactions=Transaction::join('employees', 'transactions.rm_name', '=', 'employees.full_name')
    // ->whereBetween('order_date', [$start_date, $end_date])
    // ->where('transactions.status', 'open')
    // ->whereNull('transactions.billed_qty')
    // ->groupBy('order_id', 'promo_code', 'transactions.status', 'dealer_code', 'dealer_name', 'employees.official_email')
    // ->selectRaw('order_id, promo_code, GROUP_CONCAT(order_qty) as order_qty,GROUP_CONCAT(product_type) as product_type,GROUP_CONCAT(model_no) as model_no, GROUP_CONCAT(transactions.billed_qty) as billed_qty, MAX(order_date) as order_date, transactions.status, dealer_code, dealer_name, employees.official_email')
    // ->get();
    //--------------
    // $transactions = Transaction::join('employees', 'transactions.rm_name', '=', 'employees.full_name')
    // ->whereBetween('order_date', [$start_date, $end_date])
    // ->where('transactions.status', 'open')
    // ->whereNull('transactions.billed_qty')
    // ->groupBy('order_id', 'promo_code', 'transactions.status', 'dealer_code', 'dealer_name', 'employees.official_email')
    // ->selectRaw('
    //     order_id, 
    //     promo_code, 
    //     GROUP_CONCAT(order_qty) as order_qty,
    //     GROUP_CONCAT(product_type) as product_type,
    //     GROUP_CONCAT(model_no) as model_no, 
    //     GROUP_CONCAT(transactions.billed_qty) as billed_qty, 
    //     MAX(order_date) as order_date, 
    //     transactions.status, 
    //     dealer_code, 
    //     dealer_name, 
    //     employees.official_email,
    //     CONCAT_WS(", ", GROUP_CONCAT(order_qty), GROUP_CONCAT(product_type), GROUP_CONCAT(model_no), GROUP_CONCAT(transactions.billed_qty)) as combined_column
    // ')
    // ->get();


    // \DB::enableQueryLog();

    //--------------working 

    // $designation = 'regional manager';
    // $department = 'sales';
    // $employees = $this->employeeService->getEmployeeByDesignation($designation, $department);

    // foreach( $employees as $employee ){
        
    //     $transactions = Transaction::selectRaw('
    //     transactions.order_id, 
    //     transactions.promo_code, 
    //     JSON_ARRAYAGG(JSON_OBJECT(
    //         "order_qty", transactions.order_qty,
    //         "product_type", transactions.product_type,
    //         "model_no", transactions.model_no,
    //         "billed_qty", transactions.billed_qty
    //     )) as merged_data,
    //     MAX(transactions.order_date) as order_date, 
    //     transactions.status, 
    //     transactions.dealer_code, 
    //     transactions.dealer_name, 
    //     dealer_masters.`E Mail ID` as dealer_email,
    //     transactions.rm_name
    // ')
    // ->join('dealer_masters','transactions.dealer_code', '=', 'dealer_masters.Customer')
    // ->whereBetween('transactions.order_date', [$start_date, $end_date])
    // ->where('transactions.status', 'open')
    // ->whereRaw('LOWER(TRIM(transactions.rm_name)) = LOWER(TRIM(?))', [trim(strtolower($employee->full_name))])
    // ->whereNull('transactions.billed_qty')
    // ->groupBy('transactions.order_id', 'transactions.promo_code', 'transactions.status', 'transactions.dealer_code', 'transactions.dealer_name',  'transactions.rm_name')
    // ->get();
  
    // Mail::to($employee->official_email)->send(new PromoTransactionFollowUpMail($transactions));

    // }

  //---------working

    $designation = 'regional manager';
    $department = 'sales';

    $employees = $this->employeeService->getEmployeeByDesignation($designation, $department);

    $employeeNames = $employees->pluck('full_name')->toArray();
    $employeeEmails = $employees->pluck('official_email', 'full_name')->toArray();


    $transactions = Transaction::selectRaw('
            transactions.order_id, 
            transactions.promo_code, 
            JSON_ARRAYAGG(JSON_OBJECT(
                "order_qty", transactions.order_qty,
                "product_type", transactions.product_type,
                "model_no", transactions.model_no,
                "billed_qty", transactions.billed_qty
            )) as merged_data,
            MAX(transactions.order_date) as order_date, 
            transactions.status, 
            transactions.dealer_code, 
            transactions.dealer_name, 
            dealer_masters.`E Mail ID` as dealer_email,
            transactions.rm_name
        ')
        ->join('dealer_masters', 'transactions.dealer_code', '=', 'dealer_masters.Customer')
        ->whereBetween('transactions.order_date', [$start_date, $end_date])
        ->where('transactions.status', 'open')
        ->whereNull('transactions.billed_qty')
        ->whereIn(\DB::raw('LOWER(TRIM(transactions.rm_name))'), array_map('strtolower', array_map('trim', $employeeNames)))
        ->groupBy('transactions.order_id', 'transactions.promo_code', 'transactions.status', 'transactions.dealer_code', 'transactions.dealer_name', 'transactions.rm_name')
        ->get()
        ->groupBy('rm_name');  

        foreach ($transactions as $rm_name => $transactionGroup) {
            $email = $employeeEmails[$rm_name];  
            Mail::to($email)->send(new PromoTransactionFollowUpMail($transactionGroup));
        }
        
        $this->info('Follow Up Mail Sent Successfully!');
    
    }
}
