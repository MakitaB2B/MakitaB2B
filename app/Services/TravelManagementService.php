<?php
namespace App\Services;
use App\Models\Admin\{
    BtaApplication,
    BtaExpensesBreakups,
    BtaGroupBt,
    TeamMembers,
    LtcClaim,
    LtcClaimApplication,
    LtcMiscellaneousExp
};
use Illuminate\Support\{Facades\DB, Facades\Auth, Str};
use Carbon\Carbon;
use Exception;


class TravelManagementService{

     public function ltc_claim_id(){
        
        $ltcIdExists = LtcClaim::distinct()->pluck('ltc_claim_id')->toArray();

        do {

            $ltcId = 'ltc'.str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT); //'ltc'.rand();  
    
        } while (in_array($ltcId,$ltcIdExists ));
    
        return $ltcId;

     } 
   
     public function createBTAApplication($request,$btaSlug,$applicantSlug,$travelID,$status){

        try {
            DB::transaction(function () use ($request, $applicantSlug, $btaSlug, $status) {

                $loginUserSlug=Auth::guard('admin')->user()->employee_slug;
                $teamDetails = TeamMembers::WHERE('team_member','=',$loginUserSlug)->get(['team_owner']);
                if(count($teamDetails)>0){
                    $teamManager = $teamDetails[0]->team_owner;
                }else{
                    $teamManager = null;
                }

                // Step 1: Create and save the BtaApplication
                $btaApplication = new BtaApplication([
                    'emp_slug' => $applicantSlug,
                    'starting_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->starting_date_time),
                    'ending_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->bta_ending_datetime),
                    'number_of_days' => $request->total_trip_days,
                    'place_of_visit' => $request->bta_place_of_visit,
                    'purpose_of_visit' => $request->purpose_of_visit,
                    'total_expenses' => 5000,  // Adjust as needed
                    'bta_slug' => $btaSlug,
                    'status' => $status,
                    'mannager_slug' => $teamManager,
                    'created_by' => $applicantSlug,
                ]);

                $btaApplication->save();


                // BTA Expenses Breakup Data Insertion

                $btaExpensesBreakupArr=$request->post("bta_expbreakup_date");
                $arrayCount=count($btaExpensesBreakupArr);

                for($i=0;$i<$arrayCount;$i++){

                    $btaExpBreakUp = new BtaExpensesBreakups([
                        'bta_slug' => $btaApplication->bta_slug,  // Use the slug from the BtaApplication
                        'applicant_emp_slug' => $applicantSlug,
                        'date' => $request->bta_expbreakup_date[$i],
                        'place_to_visit' => $request->trip_place_of_visit[$i],
                        'journey_fare' => $request->journey_fare[$i],
                        'accomodation' => $request->accommodation[$i],
                        'conveyance' => $request->conveyance[$i],
                        'amount' => $request->amount[$i],
                        'approval_status' => 0,
                        'btaexpbreakup_slug' => rand().rand(),
                    ]);

                    $btaExpBreakUp->save();
                }

                // Group-Bt Data Insertion
                if($request->has('groupbt_employees')){

                    $groupBTArr= $request->post("groupbt_employees");
                    $groupBTArrayCount=count($groupBTArr);

                    if($request->personal_vehicle_number != null){
                        $vechicelNumber=$request->personal_vehicle_number;
                    }
                    if($request->company_vehicle_number != null ){
                        $vechicelNumber=$request->company_vehicle_number;
                    }


                    for($i=0;$i<$groupBTArrayCount;$i++){

                        $groupBT = new BtaGroupBt([
                            'bta_slug' => $btaApplication->bta_slug,  // Use the slug from the BtaApplication
                            'vehicle_type' => $request->vehicle_type,
                            'vehicle_number' => $vechicelNumber,
                            'fuel_expenses' => $request->fuel_expenses,
                            'emp_code' => $request->groupbt_employees[$i],
                            'status' => 1,
                            'bt_starting_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->starting_date_time),
                            'bt_ending_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->bta_ending_datetime),
                            'payment_date' => Carbon::now(),
                            'oparate_by' => 1234,
                            'group_bt_slug' => rand().rand(),
                        ]);
                        $groupBT->save();
                    }

                }

            });

            // If successful
            // return response()->json(['message' => 'Data inserted successfully'], 200);
            return true;

        } catch (Exception $e) {
            // Handle the exception and return an error response
            // return response()->json(['message' => 'Failed to insert data', 'error' => $e->getMessage()], 500);
            return false;
        }
    }
    public function getAllBTRequestsForMangersTeamService(){
        $loginUserSlug=Auth::guard('admin')->user()->employee_slug;
        return BtaApplication::with(['employee:employee_slug,full_name'])->WHERE('mannager_slug','=',$loginUserSlug)->get(['emp_slug','starting_date_time','ending_date_time','number_of_days','place_of_visit','purpose_of_visit','status','bta_slug']);
    }
    public function changeBTAStatusToManagerApprovRejectService($status,$btaSlug){
        $empSlug=Auth::guard('admin')->user()->employee_slug;
        $updateStatus= BtaApplication::where('bta_slug', $btaSlug)->update(['status' => $status,'mannager_approved_by'=>$empSlug]);
        if($updateStatus){
            return true;
        }
    }
    public function checkBTAManagerApprovalStatus($btaSlug){
        return BtaApplication::where(['bta_slug'=>$btaSlug])->get(['status','mannager_approved_by']);
    }

    public function getAllLTCRequestsForMangers(){
        $loginUserSlug=Auth::guard('admin')->user()->employee_slug;
        return LtcClaimApplication::with(['employee:employee_slug,full_name'])
        ->select('ltc_claim_id','ltc_claim_applications_slug', 'employee_slug','total_claim_amount','payed_amount','ltc_month', 'ltc_year', 'status')
        ->where('manager_slug', '=', $loginUserSlug)->whereIn('status',[0,1,2])
        ->get();
    }

    public function getAllLTCRequestsForHr(){

        return LtcClaimApplication::with(['employee:employee_slug,full_name']) 
            ->select('ltc_claim_id', 'ltc_claim_applications_slug', 'employee_slug', 'total_claim_amount', 'payed_amount', 'ltc_month', 'ltc_year', 'status')
            ->whereNotNull('manager_approved_by')
            ->whereIn('status',[1,4,5])
            ->get();
    }

    public function getAllLTCRequestsForAccount(){
        return LtcClaimApplication::with(['employee:employee_slug,full_name']) 
        ->select('ltc_claim_id', 'ltc_claim_applications_slug', 'employee_slug', 'total_claim_amount', 'payed_amount', 'ltc_month', 'ltc_year', 'status')
        ->whereNotNull('manager_approved_by')->whereNotNull('hr_approved_by')
        ->whereIn('status',[4,6,7,8])
        ->get();
    }

    public function getLTCApplicationDetails($ltcappslug){

        $result = LtcClaimApplication::with([
            'employee:employee_slug,full_name',
            'ltcClaims:ltc_claim_applications_slug,ltc_claim_slug,date,mode_of_transport,opening_meter,closing_meter,total_km,place_visited,claim_amount,lunch_exp,fuel_exp,toll_charge,status',
            'ltcMiscellaneousExp:ltc_claim_applications_slug,ltc_miscellaneous_slug,courier_bill,xerox_stationary,office_expense,monthly_mobile_bills,remarks,status',
            'manager_name:employee_slug,full_name',
            'hr_name:employee_slug,full_name',
        ])
        ->where('ltc_claim_applications_slug', $ltcappslug)
        ->select('ltc_claim_applications_slug', 'ltc_claim_id', 'employee_slug', 'ltc_month', 'ltc_year', 'status', 'manager_approved_by','total_claim_amount','hr_approved_by'
        ) 
        ->first();

        // $totalClaimExpenses = $result->ltcClaims->reduce(function ($carry, $claim) {
        //     return $carry + 
        //         (float)($claim->claim_amount ?? 0) + 
        //         (float)($claim->lunch_exp ?? 0) + 
        //         (float)($claim->fuel_exp ?? 0) + 
        //         (float)($claim->toll_charge ?? 0);
        // }, 0);
    
        // $totalMiscellaneousExpenses = 0;
        // if ($result->ltcMiscellaneousExp) {
        //     $totalMiscellaneousExpenses = 
        //         (float)($result->ltcMiscellaneousExp->courier_bill ?? 0) + 
        //         (float)($result->ltcMiscellaneousExp->xerox_stationary ?? 0) + 
        //         (float)($result->ltcMiscellaneousExp->office_expense ?? 0) + 
        //         (float)($result->ltcMiscellaneousExp->monthly_mobile_bills ?? 0);
        // }
    
        // $totalExpense = $totalClaimExpenses + $totalMiscellaneousExpenses;

        return [
            'result' => $result,
            // 'total_expense' => $totalExpense,
            // 'individual_claims' => $totalClaimExpenses,
            // 'individual_miscellaneous' => $totalMiscellaneousExpenses,
        ];

    }

    public function createLtcClaim($request,$employeeSlug,$ltc_id,$status){
  
        try {

            DB::transaction(function () use ($request,$employeeSlug,$ltc_id,$status) {

                $teamDetails = TeamMembers::WHERE('team_member','=',$employeeSlug)->get(['team_owner']);

                $teamManager = count($teamDetails)>0 ? $teamDetails[0]->team_owner : null ;

                $date = $request->post("date");
                $ltcappslug = Str::slug(rand().rand());

                $total_claim_amount=array_sum($request['claim_amount'] ?? []) +
                array_sum($request['lunch_exp'] ?? []) +
                array_sum($request['fuel_exp'] ?? []) +
                array_sum($request['toll_charge'] ?? []) +
                ($request['courier_bill'] ?? 0) +
                ($request['xerox_stationary'] ?? 0) +
                ($request['office_expense'] ?? 0) +
                ($request['monthly_mobile_bill'] ?? 0);

                $ltcClaimapp = new LtcClaimApplication([
                    'ltc_claim_applications_slug' =>  $ltcappslug,
                    'ltc_claim_id' => $ltc_id,
                    'employee_slug' => $employeeSlug,
                    'ltc_month' => Carbon::parse($request->ltc_month)->month,
                    'ltc_year' => $request->ltc_year,
                    'manager_slug' => $teamManager,
                    'total_claim_amount' => $total_claim_amount
                ]);

                $ltcClaimapp->save();
              
                $ltcClaimData = [];

                foreach ($date as $index => $dateData) {
                    $ltcClaimData[] = [
                        'ltc_claim_slug' => Str::slug(rand().rand()),
                        'ltc_claim_applications_slug' =>  $ltcappslug,
                        'ltc_claim_id' => $ltc_id,
                        'employee_slug' => $employeeSlug,
                        'date' => $request->date[$index],
                        'mode_of_transport' =>$request->mode_of_transport[$index],
                        'opening_meter' => $request->opening_meter[$index],
                        'closing_meter'=> $request->closing_meter[$index],
                        'total_km' => $request->total_km[$index],
                        'place_visited' => $request->place_visited[$index],
                        'claim_amount' => $request->claim_amount[$index],
                        'lunch_exp' => $request->lunch_exp[$index],
                        'fuel_exp' => $request->fuel_exp[$index],
                        'toll_charge' => $request->toll_charge[$index],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')

                    ];
                }
            
                if (!empty($ltcClaimData)) {
                    LtcClaim::insert($ltcClaimData);
                }

                $ltcMiscellaneousExp = new LtcMiscellaneousExp([
                    'ltc_miscellaneous_slug' => Str::slug(rand().rand()),
                    'ltc_claim_applications_slug' => $ltcappslug,  // Add this back
                    'ltc_claim_id' => $ltc_id,
                    'employee_slug' => $employeeSlug,
                    'courier_bill' =>  $request->courier_bill,
                    'xerox_stationary' => $request->xerox_stationary,
                    'office_expense' => $request->office_expense,
                    'monthly_mobile_bills' => $request->monthly_mobile_bill,
                    'remarks' => $request->remarks
                ]);

                $ltcMiscellaneousExp->save();

            });

            return true;
        } catch (Exception $e) {
            return false;
        }
       
    }

    // public function checkLTCManagerApprovalStatus($ltcAppSlug){
        
    //    return LtcClaimApplication::where(['ltc_claim_applications_slug'=>$ltcAppSlug])
    //           ->select('status','manager_approved_by')
    //           ->get();
        
    // }

    public function changeLTCStatusToManagerApprovRejectService($status,$ltcSlug,$ltcAppSlug,$page){
            $empSlug=Auth::guard('admin')->user()->employee_slug;      
            $ltcslugarray=explode("-", $ltcSlug);
        if($ltcslugarray[1]=='ltc'){
            $updateStatus= LtcClaim::where('ltc_claim_slug', $ltcslugarray[0])->update(['status' => $status]);
        }elseif($ltcslugarray[1]=='ltcmis'){
            $updateStatus= LtcMiscellaneousExp::where('ltc_miscellaneous_slug', $ltcslugarray[0])->update(['status' => $status]);
        }    

        $result = LtcClaimApplication::leftJoin('ltc_claims', 'ltc_claim_applications.ltc_claim_applications_slug', '=', 'ltc_claims.ltc_claim_applications_slug')
                ->leftJoin('ltc_miscellaneous_exps', 'ltc_claim_applications.ltc_claim_applications_slug', '=', 'ltc_miscellaneous_exps.ltc_claim_applications_slug')
                ->select(DB::raw("
                    COUNT(DISTINCT ltc_claims.ltc_claim_slug) as total_claims,
                    COUNT(CASE WHEN ltc_claims.status = '1' THEN ltc_claims.status END) as claims_status_1,
                    COUNT(CASE WHEN ltc_claims.status = '2' THEN ltc_claims.status END) as claims_status_2,
                    COUNT(CASE WHEN ltc_claims.status = '4' THEN ltc_claims.status END) as claims_status_4,
                    COUNT(CASE WHEN ltc_claims.status = '5' THEN ltc_claims.status END) as claims_status_5,
                    MAX(ltc_miscellaneous_exps.status) as exp_status
                "))
                ->where('ltc_claim_applications.ltc_claim_applications_slug', $ltcAppSlug)
                ->groupBy('ltc_claim_applications.ltc_claim_applications_slug')
                ->get();

        $ltcClaimApp=LtcClaimApplication::where('ltc_claim_applications.ltc_claim_applications_slug', $ltcAppSlug);
                   
        if ($result) {
               $status = 0; 
                
               if ($result[0]['total_claims'] == $result[0]['claims_status_1'] && $result[0]['exp_status'] == 1) {
                    $status = 1; 
                    $ltcClaimApp->update(['status' => $status, 'manager_approved_by' => $empSlug]);
                } elseif (($result[0]['total_claims'] == $result[0]['claims_status_2'] && $result[0]['exp_status'] == 2) || $result[0]['total_claims'] != $result[0]['claims_status_2'] && $result[0]['claims_status_2']!=0 || $result[0]['exp_status'] == 2 ||($result[0]['total_claims'] == $result[0]['claims_status_2'] && $result[0]['exp_status'] != 2)) {
                    $status = 2;
                    $ltcClaimApp->update(['status' => $status, 'manager_approved_by' => $empSlug]);
                } 
                elseif ($result[0]['total_claims'] == $result[0]['claims_status_4'] && $result[0]['exp_status'] == 4) {
                    $status = 4;
                    $ltcClaimApp->update(['status' => $status, 'hr_approved_by' => $empSlug]);
                } elseif (($result[0]['total_claims'] == $result[0]['claims_status_5'] && $result[0]['exp_status'] == 5) || $result[0]['total_claims'] != $result[0]['claims_status_5'] && $result[0]['claims_status_5']!=0 || $result[0]['exp_status'] == 5||($result[0]['total_claims'] == $result[0]['claims_status_5'] && $result[0]['exp_status'] != 5)){
                    
                    $status = 5;
                    $ltcClaimApp->update(['status' => $status, 'hr_approved_by' => $empSlug]);
                } 
                // else {
                //     $status = 0; 
                //     $ltcClaimApp->update(['status' => $status,$page.'_approved_by' => null]);
                // }
              
                // LtcClaimApplication::where('ltc_claim_applications.ltc_claim_applications_slug', $ltcAppSlug)
                // ->update(['status' => $status, 'manager_approved_by' => $status === 0 && $page == 'manager'? null : $empSlug,
                //    'hr_approved_by' =>$status === 4 && $page == 'hr'? null : $empSlug,]);

                $overallstatus = LtcClaimApplication::with([
                    'manager_name:employee_slug,full_name',
                    'hr_name:employee_slug,full_name',
                ])->where('ltc_claim_applications_slug', $ltcAppSlug)
                ->select('status', 'manager_approved_by','hr_approved_by')
                ->get(); 
            }

        if($updateStatus){
            return $overallstatus;
        }
    }

}
?>
