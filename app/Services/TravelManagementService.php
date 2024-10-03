<?php
namespace App\Services;
use App\Models\Admin\BtaApplication;
use App\Models\Admin\BtaExpensesBreakups;
use App\Models\Admin\BtaGroupBt;
use App\Models\Admin\TeamMembers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;
use Auth;




class TravelManagementService{
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

}
?>
