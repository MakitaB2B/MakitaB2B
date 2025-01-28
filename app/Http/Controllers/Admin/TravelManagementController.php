<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TravelManagementService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use App\Models\Admin\LtcFoodClaim;

class TravelManagementController extends Controller
{
    protected $travelManagementService;
    public function __construct(TravelManagementService $travelManagementService){
        $this->travelManagementService=$travelManagementService;
    }

    public function getAllBTAppliedByLoggedInEmployee(){
        
        $employeeSlug=Auth::guard('admin')->user()->employee_slug;

        $result=$this->travelManagementService->getAllBTAppliedByLoggedInEmployeeService();

        $ltcform['grade'] = $this->travelManagementService->fetchGrade($employeeSlug);

        $ltcform['mode_of_transport'] = $this->travelManagementService->modeOfTransport($ltcform['grade']->grade);
       
        $ltcform['mobile_bill'] = $this->travelManagementService->mobileBill($ltcform['grade']->grade);
        
       return view('Admin.business_travel_list',compact('result','ltcform'));
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

        $ltc=LtcFoodClaim::all();

        dd($ltc);

        $msg = $createUpdateAction ? 'Yes! You Have Sucessfully Applied for LTC' : 'Error! LTC Application Not Executed';
        
        $request->session()->flash('message',$msg);

        return true;
            
        // return redirect('admin/travelmanagement/applyviewclaimtravelexpenses');
      
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

    public function ltcApplicationDetailsEdit($id,Request $request){

        $ltcappslug = Crypt::decrypt($id);
        $result = $this->travelManagementService->getLTCApplicationDetails($ltcappslug);
        return view('Admin.edit_ltc_application_details', [   
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
