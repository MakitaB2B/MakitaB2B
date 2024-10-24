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

    public function createLtcClaimApplication(Request $request){

        $employeeSlug=Auth::guard('admin')->user()->employee_slug;

        $ltc_id = $this->travelManagementService->ltc_claim_id();
        $status=0;

        $createUpdateAction=$this->travelManagementService->createLtcClaim($request,$employeeSlug,$ltc_id,$status);

        $msg = $createUpdateAction ? 'Yes! You Have Sucessfully Applied for LTC' : 'Error! LTC Application Not Executed';
        
        $request->session()->flash('message',$msg);
            
        return redirect('admin/travelmanagement/applyviewclaimtravelexpenses');
      
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

}
