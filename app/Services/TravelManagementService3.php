<?php
namespace App\Services;
use App\Models\Admin\BtaApplication;
use App\Models\Admin\BtaExpensesBreakups;
use App\Models\Admin\BtaGroupBt;
use App\Models\Admin\TeamMembers;
use App\Models\Admin\BtAccountLedger;
use App\Models\Admin\BtaDcEntertainmentExpenses;
use Illuminate\Support\Facades\Storage;
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
                if($request->has('gbt')){
                    $isGroupBt = 1;
                }else{
                    $isGroupBt = null;
                }

                // Step 1: Create and save the BtaApplication
                $btaApplication = new BtaApplication([
                    'emp_slug' => $applicantSlug,
                    'bta_application_id' => 'bta'.str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT),
                    'starting_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->starting_date_time),
                    'ending_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->bta_ending_datetime),
                    'number_of_days' => $request->total_trip_days,
                    'place_of_visit' => $request->bta_place_of_visit,
                    'purpose_of_visit' => $request->purpose_of_visit,
                    'total_expenses' => 6645,  // Adjust as needed
                    'bta_slug' => $btaSlug,
                    'status' => $status,
                    'is_group_bt' => $isGroupBt,
                    'manager_slug' => $teamManager,
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
    public function getAllBTAppliedByLoggedInEmployeeService(){
        $loginUserSlug=Auth::guard('admin')->user()->employee_slug;
        return BtaApplication::WHERE('emp_slug','=',$loginUserSlug)->get(['emp_slug','starting_date_time','ending_date_time','number_of_days','place_of_visit','status','bta_slug','bta_application_id','total_expenses']);
    }
    public function getAllBTRequestsForMangersTeamService(){
        $loginUserSlug=Auth::guard('admin')->user()->employee_slug;
        return BtaApplication::with(['employee:employee_slug,full_name'])->WHERE('manager_slug','=',$loginUserSlug)->get(['emp_slug','starting_date_time','ending_date_time','number_of_days','place_of_visit','purpose_of_visit','status','bta_slug','bta_application_id']);
    }
    public function changeBTAStatusToManagerApprovRejectService($status,$btaSlug){
        $empSlug=Auth::guard('admin')->user()->employee_slug;
        $updateStatus= BtaApplication::where('bta_slug', $btaSlug)->update(['status' => $status,'manager_approved_by'=>$empSlug]);
        if($updateStatus){
            return true;
        }
    }
    public function checkBTAManagerApprovalStatus($btaSlug){
        return BtaApplication::where(['bta_slug'=>$btaSlug])->get(['status','manager_approved_by']);
    }
    public function getAllBTAdvanceRequestsForAccountDeptService(){
        return BtaApplication::with(['employee:employee_slug,full_name'])->WHERE('status','=',1)->get(['emp_slug','starting_date_time','ending_date_time','number_of_days','place_of_visit','purpose_of_visit','status','bta_slug','total_expenses']);
    }
    public function getSpecificBTADetailsService($decreptedBtaSlug){
        return BtaApplication::with(['employee:employee_slug,full_name'])->WHERE(['bta_slug'=>$decreptedBtaSlug])->get(['emp_slug','starting_date_time','ending_date_time','number_of_days','place_of_visit','purpose_of_visit','status','bta_slug','total_expenses','is_group_bt','bta_application_id']);
    }
    public function getOnlySpecificBTADetailsService(){
        return BtaApplication::get(['emp_slug','starting_date_time','ending_date_time','number_of_days','place_of_visit','purpose_of_visit','status','bta_slug','total_expenses','is_group_bt']);
    }
    public function getBtaExpensesBreakUpByBtaSlug($btaSlug){
        return BtaExpensesBreakups::where(['bta_slug'=>$btaSlug])->get(['date','place_to_visit','journey_fare','accomodation','conveyance','amount','btaexpbreakup_slug','approval_status','bta_slug','journey_fare_bill_image','accommodation_bill_image']);
    }
    public function getBtaGroupBTByBtaSlug($btaSlug){
        return BtaGroupBt::with(['employee:employee_no,full_name'])->where(['bta_slug'=>$btaSlug])->get(['vehicle_type','vehicle_number','fuel_expenses','emp_code']);
    }
    public function insertBtAccountLedgerService($totalBTExpenses,$advanced90percent,$btaSlug,$empSlug,$btaalSlug,$btType){

        $amountPaidBy=Auth::guard('admin')->user()->employee_slug;


        try {
            DB::transaction(function () use ($totalBTExpenses,$advanced90percent,$btaSlug,$empSlug,$btaalSlug,$btType,$amountPaidBy) {

                $insertBTAcLedger = new BtAccountLedger([
                    'bt_type' => $btType,
                    'bt_slug' => $btaSlug,
                    'account_holder_emp_slug' => $empSlug,
                    'total_expenses_amount' => $totalBTExpenses,
                    'paid_amount' => $advanced90percent,
                    'amount_paid_by' => $amountPaidBy,
                    'btaal_slug' => $btaalSlug,
                ]);
                $insertBTAcLedger->save();

                $updateStatus= BtaApplication::where('bta_slug', $btaSlug)->update(['status' => 3,'advanced_paid_by'=>$amountPaidBy]);



            });

            // If successful
            return true;

        } catch (Exception $e) {
            // Handle the exception and return an error response
            return false;
        }
    }
    public function checkSpecBTAccountDataByBTASlugService($btaSlug){
        return BtAccountLedger::where(['bt_slug'=>$btaSlug])->get(['total_expenses_amount','paid_amount']);
    }
    public function btaApplicationRecordStatusUpdateService($status,$btabsSlug,$btSlugValue){

        try {
            DB::transaction(function () use ($status,$btabsSlug,$btSlugValue) {
            $updateStatus= BtaExpensesBreakups::where('btaexpbreakup_slug', $btabsSlug)->update(['approval_status' => $status]);
            if($updateStatus){
                $acceptedByHRRecords = BtaExpensesBreakups::where('bta_slug', $btSlugValue)->where('approval_status', 3)->count();
                $totalRecords = BtaExpensesBreakups::where('bta_slug', $btSlugValue)->count();

                if ($totalRecords === $acceptedByHRRecords) {
                    // All records have status 3
                    $updateStatus= BtaApplication::where('bta_slug', $btSlugValue)->update(['status' => 4]);
                } else {
                    // Not all records have status 3
                    $allAcceptedByHR = false;
                }
            }
            });

            return true;
        } catch (Exception $e) {
            // Handle the exception and return an error response
            return false;
        }

    }
    public function getAllBTRequestsForHRTeamService(){
        return BtaApplication::with(['employee:employee_slug,full_name'])->WHERE('status','=',3)->get(['emp_slug','starting_date_time','ending_date_time','number_of_days','place_of_visit','purpose_of_visit','status','bta_slug']);
    }

    public function btaApplicationClaimByApplicantService($request){




        // Workin code for Entertainment Expenses

        // $request->validate([
        //     'btaDCEntExpBillImage.*' => 'file|mimes:jpeg,png,jpg,pdf|max:2048', // Adjust validation rules as needed
        //     'btaDCEntExpDate.*' => 'required|date',
        //     'btaDCEntExpDescriptions.*' => 'required|string',
        //     'btaDCEntExpAmount.*' => 'required|numeric',
        //     'btaDCEntExpEnclosureNo.*' => 'required|string',
        // ]);

        // // Get uploaded files
        // $btaDCEntExpBillImageArr = $request->file('btaDCEntExpBillImage');
        // $entExpArrayCount = count($btaDCEntExpBillImageArr); // Get count of uploaded files
        // for ($i = 0; $i < $entExpArrayCount; $i++) {
        //     // Store the file
        //     $btaDCEntExpBillName = $btaDCEntExpBillImageArr[$i]->store('mimes/business_trip');

        //     // Insert or update the record in the database
        //     $operate = BtaDcEntertainmentExpenses::updateOrCreate(
        //         [
        //             'id' => $request->btaDCEntExpID[$i] ?? 0, // Use the ID from request or null for new records
        //         ],
        //         [
        //             'bta_slug' => $request->btaDCEntExpDate[$i], // Ensure it's coming from an array
        //             'applicant_emp_slug' => $request->btaDCEntExpDescriptions[$i],
        //             'date' => $request->btaDCEntExpDate[$i],
        //             'description' => $request->btaDCEntExpDescriptions[$i],
        //             'amount' => $request->btaDCEntExpAmount[$i],
        //             'encloser_number' => $request->btaDCEntExpEnclosureNo[$i],
        //             'bill_image' => $btaDCEntExpBillName,
        //             'status' => 1,
        //             'status_by' => 1,
        //         ]
        //     );
        // }



         // Workin code for BTA Expenses Bills
        // $journeyBillArr = $request->file('journey_bill'); // Get uploaded files
        // $accommodationBillArr = $request->file('accommodation_bill'); // Get uploaded files
        // $btaExpensesBreakupSlug = $request->post('business_trip_breakup_slug'); // Get the corresponding slugs

        // $arrayCount = count($journeyBillArr);

        // for ($i = 0; $i < $arrayCount; $i++) {
        //     $journeyBillName = $journeyBillArr[$i]->store('mimes/business_trip'); // Store the file
        //     $accommodationBillName = $accommodationBillArr[$i]->store('mimes/business_trip'); // Store the file


        //     // Assuming the slug is an array corresponding to the file array
        //     $slug = Crypt::decrypt($btaExpensesBreakupSlug[$i]); // Get the slug corresponding to the current file

        //     // Update the photo name in the database where the slug matches
        //     BtaExpensesBreakups::where('btaexpbreakup_slug', $slug)->update(['journey_fare_bill_image' => $journeyBillName,'accommodation_bill_image'=>$accommodationBillName]);

        // }





        // try {
        //     DB::transaction(function () use ($request) {


        //         // BTA Expenses Breakup Data Insertion

        //         // $btaExpensesBreakupArr=$request->journey_bill;
        //         // $arrayCount=count($btaExpensesBreakupArr);

        //         // for($i=0;$i<$arrayCount;$i++){

        //         //     $photo=$request->file('journey_bill')->store('mimes/business_trip');
        //         // }

        //         // $btaExpensesBreakupArr = $request->file('journey_bill'); // Use file() instead of journey_bill for fetching files
        //         // $btaExpensesBreakupSlug = $request->post('business_trip_breakup_slug');
        //         // $arrayCount = count($btaExpensesBreakupArr);

        //         // for ($i = 0; $i < $arrayCount; $i++) {
        //         //     $photo = $btaExpensesBreakupArr[$i]->store('mimes/business_trip');

        //         // }

        //         $btaExpensesBreakupArr = $request->file('journey_bill'); // Get uploaded files
        //         $btaExpensesBreakupSlug = $request->post('business_trip_breakup_slug'); // Get the corresponding slugs
        //         $arrayCount = count($btaExpensesBreakupArr);

        //         for ($i = 0; $i < $arrayCount; $i++) {
        //             $photo = $btaExpensesBreakupArr[$i]->store('mimes/business_trip'); // Store the file

        //             // Assuming the slug is an array corresponding to the file array
        //             $slug = $btaExpensesBreakupSlug[$i]; // Get the slug corresponding to the current file

        //             // Update the photo name in the database where the slug matches
        //             BtaExpensesBreakups::where('btaexpbreakup_slug', $slug)->update(['journey_fare_bill_image' => $photo]);
        //         }


        //     });

        //     // If successful
        //     // return response()->json(['message' => 'Data inserted successfully'], 200);
        //     return true;

        // } catch (Exception $e) {
        //     // Handle the exception and return an error response
        //     // return response()->json(['message' => 'Failed to insert data', 'error' => $e->getMessage()], 500);
        //     return false;
        // }
    }

}
?>
