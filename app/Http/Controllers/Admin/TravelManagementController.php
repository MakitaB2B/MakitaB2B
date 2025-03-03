<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TravelManagementService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;

class TravelManagementController extends Controller
{
    protected $travelManagementService;
    public function __construct(TravelManagementService $travelManagementService){
        $this->travelManagementService=$travelManagementService;
    }

    public function getAllBTAppliedByLoggedInEmployee(){
        
        $employeeSlug=Auth::guard('admin')->user()->employee_slug;

        $result=$this->travelManagementService->getAllBTAppliedByLoggedInEmployeeService();

        // $ltcform['grade'] = $this->travelManagementService->fetchGrade($employeeSlug);

        // $ltcform['mode_of_transport'] = $this->travelManagementService->modeOfTransport($ltcform['grade']->grade);
       
        // $ltcform['mobile_bill'] = $this->travelManagementService->mobileBill($ltcform['grade']->grade);
        
       return view('Admin.business_travel_list',compact('result'));//,'ltcform'
    }

    public function createTravelMangmentApplication(Request $request){
        $applicantSlug=Auth::guard('admin')->user()->employee_slug;
        $btaSlug=Str::slug(rand().rand());
        $travelID='bta'.rand();
        $status=0;

        $createUpdateAction=$this->travelManagementService->createBTAApplication($request,$btaSlug,$applicantSlug,$travelID,$status);

        if($createUpdateAction){
            $msg='Yes! You Have Sucessfully Applied for BTA';
            $request->session()->flash('message',$msg);
            return redirect('admin/travelmanagement/applyviewclaimtravelexpenses');
        }else{
            $msg='Error! BTA Application Not Executed';
            $request->session()->flash('message',$msg);
            return redirect('admin/travelmanagement/applyviewclaimtravelexpenses');
        }

    }

     public function getAllBTRequestsForMangersTeam(){
        $result=$this->travelManagementService->getAllBTRequestsForMangersTeamService();
        return view('Admin.bt_trips_requests_mangers',compact('result'));
     }

     public function changeBTAStatusToManagerApprovReject(Request $request){
        $status=$request->status;
        $btaSlug=$request->btaSlug;

        $checkStatus=$this->travelManagementService->checkBTAManagerApprovalStatus($btaSlug);

        if($checkStatus[0]->status == 0){
            $result=$this->travelManagementService->changeBTAStatusToManagerApprovRejectService($status,$btaSlug);
            echo "Sucess";
        }else{
            echo "Alredy Inserted Before";
        }
    }

    public function getAllBTAdvanceRequestsForAccountDept(){
        $result=$this->travelManagementService->getAllBTAdvanceRequestsForAccountDeptService();
        return view('Admin.bt_trips_advancerequests_accountdep',compact('result'));
    }

    public function getSpecificBTADetailsForAccountDepertment($btaSlug){
        $decreptedBtaSlug=Crypt::decrypt($btaSlug);
        $result['btaParentData']=$this->travelManagementService->getSpecificBTADetailsService($decreptedBtaSlug);
        $result['btaExpensesBreakup']=$this->travelManagementService->getBtaExpensesBreakUpByBtaSlug($result['btaParentData'][0]->bta_slug);
        $result['btaAccountChecker']=$this->travelManagementService->checkSpecBTAccountDataByBTASlugService($result['btaParentData'][0]->bta_slug);
        if($result['btaParentData'][0]->is_group_bt ==1 ){
            $result['btaGroupBT']=$this->travelManagementService->getBtaGroupBTByBtaSlug($result['btaParentData'][0]->bta_slug);
        }
        return view('Admin.bta_application_details_account_dep',$result);
    }

    public function getSpecificBTADetails($btaSlug){
        $decreptedBtaSlug=Crypt::decrypt($btaSlug);
        $result['btaParentData']=$this->travelManagementService->getSpecificBTADetailsService($decreptedBtaSlug);
        $result['btaExpensesBreakup']=$this->travelManagementService->getBtaExpensesBreakUpByBtaSlug($result['btaParentData'][0]->bta_slug);
        $result['btaAccountChecker']=$this->travelManagementService->checkSpecBTAccountDataByBTASlugService($result['btaParentData'][0]->bta_slug);
        if($result['btaParentData'][0]->is_group_bt ==1 ){
            $result['btaGroupBT']=$this->travelManagementService->getBtaGroupBTByBtaSlug($result['btaParentData'][0]->bta_slug);
        }
        return view('Admin.bta_application_details',$result);
    }

    public function insertBtAccountLedger(Request $request){
        $btaAmountPaying=$request->btaAmountPaying;
        $btaSlug=Crypt::decrypt($request->btaSlug);
        $empSlug=Crypt::decrypt($request->empSlug);
        $btaalSlug=Str::slug(rand().rand());
        $btType='bta';

        $specificBTADetails=$this->travelManagementService->getOnlySpecificBTADetailsService($btaSlug);
        $totalBTExpenses=$specificBTADetails[0]->total_expenses;
        $advanced90percent=round($totalBTExpenses * 0.9);

        $result=$this->travelManagementService->insertBtAccountLedgerService($totalBTExpenses,$advanced90percent,$btaSlug,$empSlug,$btaalSlug,$btType);
        if($result){
            return 1;
        }else{
            return 2;
        }
    }

    public function btaApplicationRecordStatusUpdate(Request $request){

        $status=$request->recordStatus;
        $btabsSlug=$request->btabsValue;
        $btSlugValue=$request->btSlugValue;
        $result=$this->travelManagementService->btaApplicationRecordStatusUpdateService($status,$btabsSlug,$btSlugValue);
        if($result){
            return 1;
        }

    }

    public function getAllBTRequestsForHRTeam(){
        $result=$this->travelManagementService->getAllBTRequestsForHRTeamService();
        return view('Admin.bt_trips_requests_hr',compact('result'));
    }

    public function getSpecificBTADetailsForHRProcess($btaSlug){
        $decreptedBtaSlug=Crypt::decrypt($btaSlug);
        $result['btaParentData']=$this->travelManagementService->getSpecificBTADetailsService($decreptedBtaSlug);
        $result['btaExpensesBreakup']=$this->travelManagementService->getBtaExpensesBreakUpByBtaSlug($result['btaParentData'][0]->bta_slug);
        $result['btaAccountChecker']=$this->travelManagementService->checkSpecBTAccountDataByBTASlugService($result['btaParentData'][0]->bta_slug);
        if($result['btaParentData'][0]->is_group_bt ==1 ){
            $result['btaGroupBT']=$this->travelManagementService->getBtaGroupBTByBtaSlug($result['btaParentData'][0]->bta_slug);
        }
        return view('Admin.bta_application_details_hr_process',$result);
    }

    public function btaApplicationClaimByApplicant(Request $request){

        $createUpdateAction=$this->travelManagementService->btaApplicationClaimByApplicantService($request);

        if($createUpdateAction){
            $msg='Yes! You Have Claim BTA';
            $request->session()->flash('message',$msg);
            return redirect('admin/travelmanagement/applyviewclaimtravelexpenses');
        }else{
            $msg='Error! BTA Claim Faild ';
            $request->session()->flash('message',$msg);
            return redirect('admin/travelmanagement/applyviewclaimtravelexpenses');
        }

     }

     public function ltc_application_form(){
        return view('Admin.travel-management.ltc-portal.ltc_application');
     }

    public function createLtcClaimApplication(Request $request){

        $employeeSlug=Auth::guard('admin')->user()->employee_slug;

        $ltc_id = $this->travelManagementService->ltc_claim_id();
        $status=0;
        $createUpdateAction=$this->travelManagementService->createLtcClaim($request,$employeeSlug,$ltc_id,$status);

        $msg = $createUpdateAction ? 'Yes! You Have Sucessfully Applied for LTC Please click on Edit to view all applications for the month' : 'Error! LTC Application Not Executed';
        
       // $request->session()->flash('message',$msg);

       return  $msg;// return redirect('admin/travelmanagement/applyviewclaimtravelexpenses');
      
    }

    public function ltcRequestManagers(){
        $page ='manager';
        $result=$this->travelManagementService->getAllLTCRequestsForMangers();

        return view('Admin.ltc_trips_requests_mangers',compact('result','page'));
    }

    public function ltcRequestHr(){
        $page='hr';
        $result=$this->travelManagementService->getAllLTCRequestsForHr();

        return view('Admin.ltc_trips_requests_mangers',compact('result','page'));
    }

    public function ltcRequestAccounts(){
        $page='account';
        $result=$this->travelManagementService->getAllLTCRequestsForAccount();

        return view('Admin.ltc_trips_requests_mangers',compact('result','page')); 
    }

    public function ltcApplicationDetails($id,Request $request){

        $ltcappslug = Crypt::decrypt($id);
        dd( $ltcappslug );
        $result = $this->travelManagementService->getLTCApplicationDetails($ltcappslug);
        $page = 'manager';

        // return view('Admin.ltc_application_details',['result' => $result['result'],'total_expense' => $result['total_expense']);
        return view('Admin.ltc_application_details', [
            'result' => $result['result'],
            'page' => $page
            // 'total_expense' => $result['total_expense']
        ]);

    }  
    
    public function ltcApplicationDetailsHr($id,Request $request){
    
        $ltcappslug = Crypt::decrypt($id);
        $result = $this->travelManagementService->getLTCApplicationDetails($ltcappslug);
        $page = 'hr';
        return view('Admin.ltc_application_details', [
            'result' => $result['result'],
            'page' => $page
        ]);
    }

    public function ltcApplicationDetailsAccount($id,Request $request){
        $ltcappslug = Crypt::decrypt($id);
        $result = $this->travelManagementService->getLTCApplicationDetails($ltcappslug);
        $page = 'account';
        return view('Admin.ltc_application_details', [
            'result' => $result['result'],
            'page' => $page
        ]);
    }
        
    public function ltcApplicationStatus(Request $request){
       
        $status=$request->status;
        $ltcSlug=$request->ltcSlug;
        $ltcAppSlug=$request->ltcappslug;
        $page=$request->page;
        // $checkStatus=$this->travelManagementService->checkLTCManagerApprovalStatus($ltcAppSlug);
        $result=$this->travelManagementService->changeLTCStatusToManagerApprovRejectService($status,$ltcSlug,$ltcAppSlug,$page);
           if($result){
            return $result;
           }
    }

    public function ltcApplicationPaymentStatus(Request $request){

        $status=$request->status;
        $ltcappslug=$request->ltcappslug;
        $result=$this->travelManagementService->changeStatusToPayed($status,$ltcappslug);
        return $result;

    }

    public function ltcApplicationDetailsEditPage($id,Request $request){
        $ltcappslug = Crypt::decrypt($id);
        return view('Admin.travel-management.ltc-portal.ltc_dashboard', [
           "id"=> $ltcappslug
        ]);
    }

    public function ltcApplicationDetailsEdit(Request $request){
        $id=$request->input("id");
        $ltcappslug = Crypt::decrypt($id);
        $result = $this->travelManagementService->getLTCApplicationDetails($ltcappslug);
        dd(  $result);
        return view('Admin.travel-management.ltc-portal.ltc_dashboard', [   //'Admin.edit_ltc_application_details'
            'result' => $result['result']
        ]);
      
    }

    public function ltcApplicationDetailsUpdate(Request $request){
       
        $ltcappslug =  Crypt::encrypt($request->input('ltc_claim_applications_slug')) ;

        $result = $this->travelManagementService->ltcAppUpdate($request);

        return redirect('/admin/travelmanagement/ltc-application-details/'. $ltcappslug);
    
    }

    public function calculateExpenses(Request $request){

        $openingMeter = $request->input('opening_meter');
        $closingMeter = $request->input('closing_meter');
        $modeOfTransport = $request->input('mode_of_transport');
        $transportMode = explode('|', $modeOfTransport);
        $result = $this->travelManagementService->calculateltcExpense($openingMeter,$closingMeter,$transportMode[1]);

        return $result;    
    }

    public function ltcDemoVan(Request $request){

    $datavalue = $request->input('data');
    [$dataid,$demovalue] = explode('|',  $datavalue);

    $employeeSlug=Auth::guard('admin')->user()->employee_slug;

    $demovanoptions = $this->travelManagementService->demoVanDetails($employeeSlug);

    $options = '';
    foreach($demovanoptions as $demovan) {
        $options .= '<option value="' . htmlspecialchars($demovan['vehicles_reg_no']) . '">' . htmlspecialchars($demovan['vehicles_reg_no']) . '</option>';
    }
  
    return response()->json(['options' => $options]);
    }

}

    // public function getLTCApplicationDetails($ltcappslug)
    // {
    //     $result = LtcClaimApplication::with([
    //         'employee:employee_slug,full_name',
    //         'ltcMiscellaneousExp:ltc_claim_applications_slug,ltc_miscellaneous_slug,misc_type,claim_amount',
    //         'ltcTravelClaims:ltc_claim_applications_slug,mode_of_transport',
    //         'ltcFoodClaims:ltc_claim_applications_slug,in_time,out_time,food_exp'
    //     ])
    //     ->where('ltc_claim_applications_slug', $ltcappslug)
    //     ->select(
    //         'ltc_claim_applications_slug', 'employee_slug', 'ltc_month', 'ltc_year', 
    //         'status', 'manager_approved_by', 'total_claim_amount', 
    //         'hr_approved_by', 'payment_by'
    //     ) 
    //     ->first();

    //     if (!$result) {
    //         return response()->json(['message' => 'No data found'], 404);
    //     }

        
    //     $expenseData = [
    //         [
    //             'date'         => now()->format('d-M-y'), 
    //             'inTime'       => optional($result->ltcFoodClaims->first())->in_time ?? '',
    //             'outTime'      => optional($result->ltcFoodClaims->first())->out_time ?? '',
    //             'daystat'      => 'leave', 
    //             'travelEntries' => $this->formatTravelEntries($result->ltcTravelClaims),
    //             'foodExpense'  => $this->formatFoodExpenses($result->ltcFoodClaims),
    //             'miscExpense'  => $this->formatMiscExpenses($result->ltcMiscellaneousExp),
    //             'total'        => '₹' . number_format((float) $result->total_claim_amount, 2),
    //             'status'       => $result->status == 0 ? 'Pending' : 'Approved'
    //         ]
    //     ];

    //     return response()->json($expenseData);
    // }


    // private function formatTravelEntries($travelClaims)
    // {
    //     return $travelClaims->map(function ($claim) {
    //         return [
    //             'modeOfTransport' => $claim->mode_of_transport ?? '',
    //             'typeOfTransport' => '', 
    //             'startingMeter'   => '', 
    //             'closingMeter'    => '', 
    //             'totalKms'        => '', 
    //             'tollCharges'     => '', 
    //             'fuelCharges'     => '', 
    //             'placesVisited'   => '', 
    //             'files'           => []  
    //         ];
    //     })->toArray();
    // }

    // private function formatFoodExpenses($foodClaims)
    // {
    //     return $foodClaims->map(function ($claim) {
    //         return [
    //             'breakfast' => ['amount' => '', 'files' => []], 
    //             'lunch'     => ['amount' => $claim->food_exp ?? '0.00', 'files' => []],
    //             'dinner'    => ['amount' => '', 'files' => []]  
    //         ];
    //     })->toArray();
    // }

    // private function formatMiscExpenses($miscExpenses)
    // {
    //     return $miscExpenses->map(function ($misc) {
    //         return [
    //             'type'  => $misc->misc_type ?? '',
    //             'amount' => $misc->claim_amount ?? '0.00',
    //             'files'  => [] 
    //         ];
    //     })->toArray();
    // }

//--------------------------------------------------------

// public function getLTCApplicationDetails($ltcappslug){
    
//     $result = LtcClaimApplication::with([
//         'employee:employee_slug,full_name',
//         'ltcClaims:ltc_claim_applications_slug,ltc_claim_slug,date,mode_of_transport,opening_meter,closing_meter,total_km,place_visited,claim_amount,lunch_exp,fuel_exp,toll_charge,status,modified',
//         'ltcMiscellaneousExp:ltc_claim_applications_slug,ltc_miscellaneous_slug,misc_type,claim_amount',
//         'ltcTravelClaims:ltc_claim_applications_slug,mode_of_transport,type_of_transport,starting_meter,closing_meter,total_kms,toll_charges,fuel_charges,places_visited',
//         'ltcFoodClaims:ltc_claim_applications_slug,in_time,out_time,food_exp,breakfast_amount,lunch_amount,dinner_amount',
//         'ltcFiles:ltc_claim_applications_slug,file_category,file_name,file_type,uploaded_at'
//     ])
//     ->where('ltc_claim_applications_slug', $ltcappslug)
//     ->select('ltc_claim_applications_slug', 'employee_slug', 'ltc_month', 'ltc_year', 'status', 'manager_approved_by','total_claim_amount','hr_approved_by','payment_by', 'date', 'day_status')
//     ->first();

//     if (!$result) {
//         return ['result' => null];
//     }

//     $formattedData = [
//         'ltc_claim_applications_slug' => $result->ltc_claim_applications_slug,
//         'employee_slug' => $result->employee_slug,
//         'employee_name' => $result->employee->full_name ?? null,
//         'ltc_month' => $result->ltc_month,
//         'ltc_year' => $result->ltc_year,
//         'status' => $this->getStatusText($result->status),
//         'total_claim_amount' => $result->total_claim_amount,
//         'expenseData' => []
//     ];

//     $files = [];
//     if (isset($result->ltcFiles)) {
//         foreach ($result->ltcFiles as $file) {
//             $category = $file->file_category;
//             if (!isset($files[$category])) {
//                 $files[$category] = [];
//             }
//             $files[$category][] = [
//                 'name' => $file->file_name,
//                 'type' => $file->file_type,
//                 'timestamp' => strtotime($file->uploaded_at) * 1000 
//             ];
//         }
//     }

//     $date = date('d-M-y', strtotime($result->date));
    
//     $expenseEntry = [
//         'date' => $date,
//         'inTime' => $result->ltcFoodClaims->in_time ?? null,
//         'outTime' => $result->ltcFoodClaims->out_time ?? null,
//         'daystat' => $result->day_status ?? 'work',
//         'travelEntries' => [],
//         'foodExpense' => [],
//         'miscExpense' => [],
//         'total' => '₹' . number_format((float)$result->total_claim_amount, 2),
//         'status' => $this->getStatusText($result->status)
//     ];

//     if (isset($result->ltcTravelClaims)) {
//         foreach ($result->ltcTravelClaims as $travel) {
//             $travelEntry = [
//                 'modeOfTransport' => $travel->mode_of_transport,
//                 'typeOfTransport' => $travel->type_of_transport ?? 'N/A',
//                 'startingMeter' => $travel->starting_meter ?? 'N/A',
//                 'closingMeter' => $travel->closing_meter ?? 'N/A',
//                 'totalKms' => $travel->total_kms ?? 'N/A',
//                 'tollCharges' => $travel->toll_charges ?? '0',
//                 'fuelCharges' => $travel->fuel_charges ?? '0',
//                 'placesVisited' => $travel->places_visited ?? 'N/A',
//                 'files' => $files['travel_' . $travel->id] ?? []
//             ];
//             $expenseEntry['travelEntries'][] = $travelEntry;
//         }
//     }

//     if (isset($result->ltcFoodClaims)) {
//         $foodExpense = [
//             'breakfast' => [
//                 'amount' => number_format((float)($result->ltcFoodClaims->breakfast_amount ?? 0), 2),
//                 'files' => $files['food_breakfast'] ?? []
//             ],
//             'lunch' => [
//                 'amount' => number_format((float)($result->ltcFoodClaims->lunch_amount ?? 0), 2),
//                 'files' => $files['food_lunch'] ?? []
//             ],
//             'dinner' => [
//                 'amount' => number_format((float)($result->ltcFoodClaims->dinner_amount ?? 0), 2),
//                 'files' => $files['food_dinner'] ?? []
//             ]
//         ];
//         $expenseEntry['foodExpense'][] = $foodExpense;
//     }

//     if (isset($result->ltcMiscellaneousExp)) {
//         foreach ($result->ltcMiscellaneousExp as $misc) {
//             $miscType = $this->getMiscTypeText($misc->misc_type);
//             $miscEntry = [
//                 'type' => $miscType,
//                 'amount' => number_format((float)($misc->claim_amount ?? 0), 2),
//                 'files' => $files['misc_' . $misc->ltc_miscellaneous_slug] ?? []
//             ];
//             $expenseEntry['miscExpense'][] = $miscEntry;
//         }
//     }

//     $formattedData['expenseData'][] = $expenseEntry;

//     return [
//         'result' => $formattedData
//     ];
// }


// private function getStatusText($status) {
//     $statusMap = [
//         0 => 'Pending',
//         1 => 'Manager Approved',
//         2 => 'HR Approved',
//         3 => 'Paid',
//         4 => 'Rejected'
//     ];
    
//     return $statusMap[$status] ?? 'Unknown';
// }


// private function getMiscTypeText($type) {
//     $typeMap = [
//         'courier' => 'Courier Bill',
//         'xerox' => 'Xerox & Stationary',
//         'office' => 'Office Expense',
//         'phone' => 'Monthly Mobile Bills'
//     ];
    
//     return $typeMap[$type] ?? $type;
// }

//-----------------------------------------------
// public function getLTCApplicationDetails($ltcappslug)
// {
//     $result = LtcClaimApplication::with([
//         'employee:employee_slug,full_name',
//         'ltcMiscellaneousExp:ltc_claim_applications_slug,ltc_miscellaneous_slug,misc_type,claim_amount',
//         'ltcTravelClaims:ltc_claim_applications_slug,mode_of_transport',
//         'ltcFoodClaims:ltc_claim_applications_slug,in_time,out_time,food_exp'
//     ])
//     ->where('ltc_claim_applications_slug', $ltcappslug)
//     ->select(
//         'ltc_claim_applications_slug', 'employee_slug', 'ltc_month', 'ltc_year', 
//         'status', 'manager_approved_by', 'total_claim_amount', 
//         'hr_approved_by', 'payment_by'
//     ) 
//     ->first();

//     if (!$result) {
//         return response()->json(['message' => 'No data found'], 404);
//     }

//     $expenseData = [
//         [
//             'date'         => now()->format('d-M-y'), 
//             'inTime'       => optional($result->ltcFoodClaims->first())->in_time ?? '',
//             'outTime'      => optional($result->ltcFoodClaims->first())->out_time ?? '',
//             'daystat'      => 'leave', 
//             'travelEntries' => $this->formatTravelEntries($result->ltcTravelClaims),
//             'foodExpense'  => $this->formatFoodExpenses($result->ltcFoodClaims),
//             'miscExpense'  => $this->formatMiscExpenses($result->ltcMiscellaneousExp),
//             'total'        => '₹' . number_format((float) $result->total_claim_amount, 2),
//             'status'       => $result->status == 0 ? 'Pending' : 'Approved'
//         ]
//     ];

//     return response()->json($expenseData);
// }


// private function formatTravelEntries($travelClaims)
// {
//     return $travelClaims->map(function ($claim) {
//         return [
//             'modeOfTransport' => $claim->mode_of_transport ?? '',
//             'typeOfTransport' => '', 
//             'startingMeter'   => '', 
//             'closingMeter'    => '', 
//             'totalKms'        => '', 
//             'tollCharges'     => '', 
//             'fuelCharges'     => '', 
//             'placesVisited'   => '', 
//             'files'           => []  
//         ];
//     })->toArray();
// }


// private function formatFoodExpenses($foodClaims)
// {
//     return $foodClaims->map(function ($claim) {
//         return [
//             'breakfast' => ['amount' => '', 'files' => []], 
//             'lunch'     => ['amount' => $claim->food_exp ?? '0.00', 'files' => []],
//             'dinner'    => ['amount' => '', 'files' => []]  
//         ];
//     })->toArray();
// }

// private function formatMiscExpenses($miscExpenses)
// {
//     return $miscExpenses->map(function ($misc) {
//         return [
//             'type'  => $misc->misc_type ?? '',
//             'amount' => $misc->claim_amount ?? '0.00',
//             'files'  => [] 
//         ];
//     })->toArray();
// }

