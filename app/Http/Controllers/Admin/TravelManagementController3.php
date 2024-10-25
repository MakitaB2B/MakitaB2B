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
        $result=$this->travelManagementService->getAllBTAppliedByLoggedInEmployeeService();
        return view('Admin.business_travel_list',compact('result'));
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

}
