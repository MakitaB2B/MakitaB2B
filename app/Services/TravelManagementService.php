<?php
namespace App\Services;

use App\Models\Admin\BtaApplication;
use App\Models\Admin\BtaExpensesBreakups;
use App\Models\Admin\BtaGroupBt;
use App\Models\Admin\TeamMembers;
use App\Models\Admin\LtcClaim;
use App\Models\Admin\LtcTravelClaim;
use App\Models\Admin\LtcClaimApplication;
use App\Models\Admin\LtcFoodClaim;
use App\Models\Admin\LtcMiscellaneousExp;
use App\Models\Admin\BtAccountLedger;
use App\Models\Admin\BtaDcEntertainmentExpenses;
use App\Models\Admin\Employee;
use App\Models\Admin\Grade;
use App\Models\Admin\LocalConveyance;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Admin\MobileExpense;

use App\Models\Admin\LtcFiles;
use Exception;
use Illuminate\Support\Facades\Validator;


class TravelManagementService{

    // private const TRANSPORT_RATES = [
    //     'Own Vehicle-4-Wheeler' => 12.0,
    //     'Own Vehicle-2-Wheeler' => 8.0
    // ];

    public function ltc_claim_id(){
        
        $ltcIdExists = LtcFoodClaim::distinct()->pluck('ltc_claim_id')->toArray(); //LtcClaim

        do {

            $ltcId = 'ltc'.str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT); //'ltc'.rand();  
    
        } while (in_array($ltcId,$ltcIdExists));
    
        return $ltcId;

    } 
   
    //  public function createBTAApplication($request,$btaSlug,$applicantSlug,$travelID,$status){

    //     try {
    //        DB::transaction(function () use ($request, $applicantSlug, $btaSlug, $status) {

    //             $loginUserSlug=Auth::guard('admin')->user()->employee_slug;
    //             $teamDetails = TeamMembers::WHERE('team_member','=',$loginUserSlug)->get(['team_owner']);
    //             if(count($teamDetails)>0){
    //                 $teamManager = $teamDetails[0]->team_owner;
    //             }else{
    //                 $teamManager = null;
    //             }

    //             // Step 1: Create and save the BtaApplication
    //             $btaApplication = new BtaApplication([
    //                 'bta_application_id' => 'bta'.str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT),
    //                 'emp_slug' => $applicantSlug,
    //                 'starting_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->starting_date_time),
    //                 'ending_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->bta_ending_datetime),
    //                 'number_of_days' => $request->total_trip_days,
    //                 'place_of_visit' => $request->bta_place_of_visit,
    //                 'purpose_of_visit' => $request->purpose_of_visit,
    //                 'total_expenses' => 5000,  // Adjust as needed
    //                 'bta_slug' => $btaSlug,
    //                 'status' => $status,
    //                 'manager_slug' => $teamManager,
    //                 'created_by' => $applicantSlug,
    //             ]);

    //             $btaApplication->save();


    //             // BTA Expenses Breakup Data Insertion

    //             $btaExpensesBreakupArr=$request->post("bta_expbreakup_date");
    //             $arrayCount=count($btaExpensesBreakupArr);

    //             for($i=0;$i<$arrayCount;$i++){

    //                 $btaExpBreakUp = new BtaExpensesBreakups([
    //                     'bta_slug' => $btaApplication->bta_slug,  // Use the slug from the BtaApplication
    //                     'applicant_emp_slug' => $applicantSlug,
    //                     'date' => $request->bta_expbreakup_date[$i],
    //                     'place_to_visit' => $request->trip_place_of_visit[$i],
    //                     'journey_fare' => $request->journey_fare[$i],
    //                     'accomodation' => $request->accommodation[$i],
    //                     'conveyance' => $request->conveyance[$i],
    //                     'amount' => $request->amount[$i],
    //                     'approval_status' => 0,
    //                     'btaexpbreakup_slug' => rand().rand(),
    //                 ]);

    //                 $btaExpBreakUp->save();
    //             }

    //             // Group-Bt Data Insertion
    //             if($request->has('groupbt_employees')){

    //                 $groupBTArr= $request->post("groupbt_employees");
    //                 $groupBTArrayCount=count($groupBTArr);

    //                 if($request->personal_vehicle_number != null){
    //                     $vechicelNumber=$request->personal_vehicle_number;
    //                 }
    //                 if($request->company_vehicle_number != null ){
    //                     $vechicelNumber=$request->company_vehicle_number;
    //                 }


    //                 for($i=0;$i<$groupBTArrayCount;$i++){

    //                     $groupBT = new BtaGroupBt([
    //                         'bta_slug' => $btaApplication->bta_slug,  // Use the slug from the BtaApplication
    //                         'vehicle_type' => $request->vehicle_type,
    //                         'vehicle_number' => $vechicelNumber,
    //                         'fuel_expenses' => $request->fuel_expenses,
    //                         'emp_code' => $request->groupbt_employees[$i],
    //                         'status' => 1,
    //                         'bt_starting_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->starting_date_time),
    //                         'bt_ending_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->bta_ending_datetime),
    //                         'payment_date' => Carbon::now(),
    //                         'oparate_by' => 1234,
    //                         'group_bt_slug' => rand().rand(),
    //                     ]);
    //                     $groupBT->save();
    //                 }

    //             }

    //         });

    //         // If successful
    //         // return response()->json(['message' => 'Data inserted successfully'], 200);
    //         // return true;

    //     } catch (Exception $e) {
    //         // Handle the exception and return an error response
    //         // return response()->json(['message' => 'Failed to insert data', 'error' => $e->getMessage()], 500);
    //     //     return false;
    //     }
    // }

    public function getAllBTAppliedByLoggedInEmployeeService(){
        $loginUserSlug=Auth::guard('admin')->user()->employee_slug;

        $ltcApplications = LtcClaimApplication::where('employee_slug', '=', $loginUserSlug)
        ->get(['employee_slug', 'ltc_month', 'ltc_year', 'status', 'ltc_claim_applications_slug', 'total_claim_amount'])
        ->map(function ($item) {
            return [
                'application_type' => 'LTC',
                'start_date' => $item->ltc_month . ' ' . $item->ltc_year,
                'end_date' => null, // No end date for LTC applications
                'place_of_visit' => null, // Not applicable for LTC
                'total_expenses' => $item->total_claim_amount,
                'status' => $item->status,
                'slug' => $item->ltc_claim_applications_slug,
            ];
        });
    
        $btaApplications = BtaApplication::where('emp_slug', '=', $loginUserSlug)
            ->get(['emp_slug', 'starting_date_time', 'ending_date_time', 'number_of_days', 'place_of_visit', 'status', 'bta_slug', 'bta_application_id', 'total_expenses'])
            ->map(function ($item) {
                return [
                    'application_type' => 'BTA',
                    'application_id' => $item->bta_application_id,
                    'start_date' => $item->starting_date_time,
                    'end_date' => $item->ending_date_time,
                    'place_of_visit' => $item->place_of_visit,
                    'total_expenses' => $item->total_expenses,
                    'status' => $item->status,
                    'slug' => $item->bta_slug,
                ];
        });
       $allApplications = $ltcApplications->toBase()->merge($btaApplications);       //$ltcApplications->merge($btaApplications);

       return $allApplications;
    }

    // public function getAllBTRequestsForMangersTeamService(){
    //     $loginUserSlug=Auth::guard('admin')->user()->employee_slug;
    //     return BtaApplication::with(['employee:employee_slug,full_name'])->WHERE('mannager_slug','=',$loginUserSlug)->get(['emp_slug','starting_date_time','ending_date_time','number_of_days','place_of_visit','purpose_of_visit','status','bta_slug']);
    // }

    // public function changeBTAStatusToManagerApprovRejectService($status,$btaSlug){
    //     $empSlug=Auth::guard('admin')->user()->employee_slug;
    //     $updateStatus= BtaApplication::where('bta_slug', $btaSlug)->update(['status' => $status,'mannager_approved_by'=>$empSlug]);
    //     if($updateStatus){
    //         return true;
    //     }
    // }

    // public function checkBTAManagerApprovalStatus($btaSlug){
    //     return BtaApplication::where(['bta_slug'=>$btaSlug])->get(['status','mannager_approved_by']);
    // }

    // public function getAllBTAdvanceRequestsForAccountDeptService(){
    //     return BtaApplication::with(['employee:employee_slug,full_name'])->WHERE('status','=',1)->get(['emp_slug','starting_date_time','ending_date_time','number_of_days','place_of_visit','purpose_of_visit','status','bta_slug','total_expenses']);
    // }

    // public function getSpecificBTADetailsService($decreptedBtaSlug){
    //     return BtaApplication::with(['employee:employee_slug,full_name'])->WHERE(['bta_slug'=>$decreptedBtaSlug])->get(['emp_slug','starting_date_time','ending_date_time','number_of_days','place_of_visit','purpose_of_visit','status','bta_slug','total_expenses','is_group_bt','bta_application_id']);
    // }

    // public function getOnlySpecificBTADetailsService(){
    //     return BtaApplication::get(['emp_slug','starting_date_time','ending_date_time','number_of_days','place_of_visit','purpose_of_visit','status','bta_slug','total_expenses','is_group_bt']);
    // }

    // public function getBtaExpensesBreakUpByBtaSlug($btaSlug){
    //     return BtaExpensesBreakups::where(['bta_slug'=>$btaSlug])->get(['date','place_to_visit','journey_fare','accomodation','conveyance','amount','btaexpbreakup_slug','approval_status','bta_slug','journey_fare_bill_image','accommodation_bill_image']);
    // }

    // public function getBtaGroupBTByBtaSlug($btaSlug){
    //     return BtaGroupBt::with(['employee:employee_no,full_name'])->where(['bta_slug'=>$btaSlug])->get(['vehicle_type','vehicle_number','fuel_expenses','emp_code']);
    // }

    // public function insertBtAccountLedgerService($totalBTExpenses,$advanced90percent,$btaSlug,$empSlug,$btaalSlug,$btType){

    //     $amountPaidBy=Auth::guard('admin')->user()->employee_slug;

    //     try {
    //         DB::transaction(function () use ($totalBTExpenses,$advanced90percent,$btaSlug,$empSlug,$btaalSlug,$btType,$amountPaidBy) {

    //             $insertBTAcLedger = new BtAccountLedger([
    //                 'bt_type' => $btType,
    //                 'bt_slug' => $btaSlug,
    //                 'account_holder_emp_slug' => $empSlug,
    //                 'total_expenses_amount' => $totalBTExpenses,
    //                 'paid_amount' => $advanced90percent,
    //                 'amount_paid_by' => $amountPaidBy,
    //                 'btaal_slug' => $btaalSlug,
    //             ]);
    //             $insertBTAcLedger->save();

    //             $updateStatus= BtaApplication::where('bta_slug', $btaSlug)->update(['status' => 3,'advanced_paid_by'=>$amountPaidBy]);



    //         });

    //         return true;

    //     } catch (Exception $e) {
    //         return false;
    //     }
    // }

    // public function checkSpecBTAccountDataByBTASlugService($btaSlug){
    //     return BtAccountLedger::where(['bt_slug'=>$btaSlug])->get(['total_expenses_amount','paid_amount']);
    // }

    // public function btaApplicationRecordStatusUpdateService($status,$btabsSlug,$btSlugValue){

    //     try {
    //         DB::transaction(function () use ($status,$btabsSlug,$btSlugValue) {
    //         $updateStatus= BtaExpensesBreakups::where('btaexpbreakup_slug', $btabsSlug)->update(['approval_status' => $status]);
    //         if($updateStatus){
    //             $acceptedByHRRecords = BtaExpensesBreakups::where('bta_slug', $btSlugValue)->where('approval_status', 3)->count();
    //             $totalRecords = BtaExpensesBreakups::where('bta_slug', $btSlugValue)->count();

    //             if ($totalRecords === $acceptedByHRRecords) {
    //                 // All records have status 3
    //                 $updateStatus= BtaApplication::where('bta_slug', $btSlugValue)->update(['status' => 4]);
    //             } else {
    //                 // Not all records have status 3
    //                 $allAcceptedByHR = false;
    //             }
    //         }
    //         });

    //         return true;
    //     } catch (Exception $e) {
    //         return false;
    //     }

    // }

    // public function getAllBTRequestsForHRTeamService(){
    //     return BtaApplication::with(['employee:employee_slug,full_name'])->WHERE('status','=',3)->get(['emp_slug','starting_date_time','ending_date_time','number_of_days','place_of_visit','purpose_of_visit','status','bta_slug']);
    // }

    // public function btaApplicationClaimByApplicantService($request){
    
    // }    

    // public function getAllLTCRequestsForMangers(){
    //     $loginUserSlug=Auth::guard('admin')->user()->employee_slug;
    //     return LtcClaimApplication::with(['employee:employee_slug,full_name'])
    //     ->select('ltc_claim_id','ltc_claim_applications_slug', 'employee_slug','total_claim_amount','payed_amount','ltc_month', 'ltc_year', 'status')
    //     ->where('manager_slug', '=', $loginUserSlug)->whereIn('status',[0,1,2])
    //     ->orderByRaw("FIELD(status, 0, 2, 1)")
    //     ->get();
    // }

    // public function getAllLTCRequestsForHr(){

    //     return LtcClaimApplication::with(['employee:employee_slug,full_name']) 
    //         ->select('ltc_claim_id', 'ltc_claim_applications_slug', 'employee_slug', 'total_claim_amount', 'payed_amount', 'ltc_month', 'ltc_year', 'status')
    //         ->whereNotNull('manager_approved_by')
    //         ->whereIn('status',[1,4,5])
    //         ->orderByRaw("FIELD(status, 1, 5, 4)")
    //         ->get();
    // }

    // public function getAllLTCRequestsForAccount(){
    //     return LtcClaimApplication::with(['employee:employee_slug,full_name']) 
    //     ->select('ltc_claim_id', 'ltc_claim_applications_slug', 'employee_slug', 'total_claim_amount', 'payed_amount', 'ltc_month', 'ltc_year', 'status')
    //     ->whereNotNull('manager_approved_by')->whereNotNull('hr_approved_by')
    //     ->whereIn('status',[4,6,7,8,3])
    //     ->orderByRaw("FIELD(status, 4, 8, 6, 7, 3)")
    //     ->get();
    // }


    // ----LTC---

    public function getLTCApplicationDetails($ltcappslug){
       
        $result = LtcClaimApplication::with([
            // 'employee:employee_slug,full_name',
            //'ltcTravelClaims.travelFiles:type,file_path,file_type,ltc_claim_id',
            'ltcMiscellaneousExp:ltc_claim_applications_slug,ltc_miscellaneous_slug,misc_type,claim_amount,ltc_claim_id',
            'ltcTravelClaims:ltc_claim_applications_slug,mode_of_transport,type_of_transport,place_visited,opening_meter,closing_meter,total_km,toll_charge,claim_amount,ltc_claim_id,ltc_travel_claims_slug',
            'ltcFoodClaims:ltc_claim_applications_slug,in_time,out_time,food_exp,ltc_date,ltc_claim_id,ltc_day,food_exp_bill,status',
            'travelFiles',
            'miscFiles'
        ])
        ->where('ltc_claim_applications_slug', $ltcappslug)
        ->select(
            'ltc_claim_applications_slug', 'employee_slug', 'ltc_month', 'ltc_year', 
            'status', 'manager_approved_by', 'total_claim_amount', 
            'hr_approved_by', 'payment_by'
        )->first();

        if (!$result) {
            return response()->json(['message' => 'No data found'], 404);
        }

        $foodClaim=[];
        foreach ($result->ltcFoodClaims as $key => $ltcFoodClaim) {
            $foodClaim[] = [
                'date'          => $ltcFoodClaim->ltc_date ?? '',
                'inTime'        => $ltcFoodClaim->in_time ?? '',
                'outTime'       => $ltcFoodClaim->out_time ?? '',
                'daystat'       => $ltcFoodClaim->ltc_day ?? '',
                'travelEntries' => $this->formatTravelEntries($result->ltcTravelClaims, $result->travelFiles, $ltcFoodClaim->ltc_claim_id),
                'miscExpense' => $this->formatMiscExpenses($result->ltcMiscellaneousExp, $result->miscFiles, $ltcFoodClaim->ltc_claim_id),
                'foodExpense' =>[ 
                    "breakfast"=> [
                    "amount" =>  $ltcFoodClaim->food_exp,
                    "files" => [
                        "path"=> $ltcFoodClaim->food_exp_bill
                     ]

                    ]
                    ],
                 'total'        => '₹' . number_format((float) $this->calculateLtcTotalAmount($result->ltcTravelClaims, $result->ltcMiscellaneousExp, $ltcFoodClaim->food_exp,$ltcFoodClaim->ltc_claim_id), 2),
                 'status'       => $this->travelApplicationStatus($ltcFoodClaim->status),
            ];

        }
       
        return response()->json([
            'overall_status' => $this->travelApplicationStatus($result->status,$result->manager_approved_by,$result->hr_approved_by,$result->payment_by),
            'total_claim_amount' => '₹' . number_format((float) $result->total_claim_amount, 2),
            'records' =>  $foodClaim
        ]);
        
    }

    public function createLtcClaim($request,$employeeSlug,$ltc_id,$status){

        try {
              
            DB::transaction(function () use ($request,$employeeSlug,$ltc_id,$status) {

                $teamDetails = TeamMembers::WHERE('team_member','=',$employeeSlug)->get(['team_owner']);
                $teamManager = count($teamDetails)>0 ? $teamDetails[0]->team_owner : null ;

                $timeInfo = $request->input('timeInfo') ? json_decode($request->input('timeInfo'), true) : [];
                $foodExpense = $request->input('foodExpense') ? json_decode($request->input('foodExpense'), true) : [];
                $travelEntries = $request->input('travelEntries') ? json_decode($request->input('travelEntries'), true) : [];
                $miscExpenses = $request->input('miscExpenses') ? json_decode($request->input('miscExpenses'), true) : [];
                $ltcappslug = Str::slug(rand().rand());
                $FilesData = [];
                $total_claim_amount=0;

                $date = Carbon::parse($timeInfo["date"]);
                $month = $date->month;
                $year = $date->year;
                //  dump(  $timeInfo,$foodExpense,$travelEntries,    $miscExpenses);

                $total_claim_amount =  (float) $foodExpense["breakfast"]["amount"] +
                array_sum(array_column($travelEntries, "fuelCharges")) +
                array_sum(array_column($travelEntries, "tollCharges")) +
                array_sum(array_column($miscExpenses, "amount"));
                //expections to be added
                //claim already submitted/ claim can be done for 2 months
                $ltcClaimApp = LtcClaimApplication::where('ltc_month',$month)->where('ltc_year', $year)->where('employee_slug',$employeeSlug)->where('status',0)->first();
    
                if(empty($ltcClaimApp)){   //if($ltcClaimApp->isEmpty()){
                $ltcClaimapp = new LtcClaimApplication([
                'ltc_claim_applications_slug' =>  $ltcappslug,
                'employee_slug' => $employeeSlug,
                'ltc_month' => (int) $month ,
                'ltc_year' => (int)  $year,
                'manager_slug' => $teamManager,
                'total_claim_amount' => $total_claim_amount
                ]);

                $ltcClaimapp->save();

                }else{
                  
                $ltcClaimapp = LtcClaimApplication::where('ltc_month', $month)
                ->where('ltc_year', $year)
                ->where('employee_slug', $employeeSlug)
                ->where('status', 0)
                ->update([
                    'total_claim_amount' => \DB::raw("COALESCE(total_claim_amount, 0) + $total_claim_amount")
                ]);

                $ltcClaimapp = LtcClaimApplication::where('ltc_month',$month)->where('ltc_year', $year)->where('employee_slug',$employeeSlug)->where('status',0)->first();
                   
                }


                $ltcFoodClaim = new LtcFoodClaim([
                    'ltc_food_claims_slug' => Str::slug(rand().rand()),
                    'ltc_claim_applications_slug' =>  $ltcClaimapp->ltc_claim_applications_slug,
                    'ltc_claim_id' => $ltc_id,     
                    'employee_slug' => $employeeSlug,
                    'ltc_date' => $timeInfo["date"],
                    'ltc_day' => $timeInfo["dayType"],
                    'claim_date' => date('Y-m-d H:i:s'),
                    'in_time' => $timeInfo["date"]." ".$timeInfo["inTime"]["hours"].":".$timeInfo["inTime"]["minutes"],
                    'out_time' => $timeInfo["date"]." ".$timeInfo["outTime"]["hours"].":".$timeInfo["outTime"]["minutes"],
                    'food_exp'=> $foodExpense["breakfast"]["amount"] ?? 0, 
                    'food_exp_bill' =>  $request->hasFile("breakfast_files") ? $request->file("breakfast_files")[0]->store('mimes/travel_management/ltc/food_info') : null,  
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
               
                $ltcFoodClaim->save();

                $ltcTravelClaimData = [];

                foreach ($travelEntries as $index => $Data) {
                    $travelClaimSlug = Str::slug(rand().rand());
                    $ltcTravelClaimData[] = [
                        'ltc_travel_claims_slug' =>  $travelClaimSlug,
                        'ltc_claim_applications_slug' => $ltcClaimapp->ltc_claim_applications_slug,
                        'ltc_claim_id' => $ltc_id,
                        'mode_of_transport'=> $Data["modeOfTransport"],
                        'employee_slug' => $employeeSlug,
                        'type_of_transport' => $Data["typeOfTransport"],
                        'claim_date' => date('Y-m-d H:i:s'),
                        'place_visited' => $Data["placesVisited"] ?? null,          
                        'opening_meter' => $Data["startingMeter"] ?? 0,         
                        'demo_van_no'=>  null,
                        'closing_meter'=> $Data["closingMeter"] ?? 0,  
                        'total_km' => $Data["totalKms"] ?? 0,                                                
                        'toll_charge' => $Data["tollCharges"] ?? 0,                                                   
                        'claim_amount' => $Data["fuelCharges"] ?? 0,                                                      
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')

                    ];
             
                    if ($request->hasFile("travel_files_{$index}")) {

                        foreach ($request->file("travel_files_{$index}") as $file) {
                        $filePath = $file->store('mimes/travel_management/ltc/travel');
            
                        $FilesData[] = [
                            'ltc_files_slug' =>Str::slug(rand().rand()),
                            'employee_slug' => $employeeSlug,
                            'type' => 'travel',
                            'file_type' => $file->getClientOriginalExtension(),
                            'file_path' => $filePath,
                            'ltc_claim_id' => $ltc_id,
                            'claim_date' => date('Y-m-d H:i:s'),
                            'status' => 0,
                            'fileable_id' => $travelClaimSlug, 
                            'fileable_type' => LtcTravelClaim::class,
                            'ltc_claim_applications_slug' =>   $ltcClaimapp->ltc_claim_applications_slug,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];
                    }
                }

                }
           
                if (!empty($ltcTravelClaimData)) {
                    LtcTravelClaim::insert($ltcTravelClaimData);
                }

                $filteredExpenses = array_filter($miscExpenses, fn($expense) => !empty($expense['type']) && !empty($expense['amount']) && $expense['amount'] > 0);

                $ltcMiscData = [];

                foreach ($filteredExpenses as $index => $Data) {
                    $miscClaimSlug = Str::slug(rand().rand());
                    $ltcMiscData[] = [
                    'ltc_miscellaneous_slug' => $miscClaimSlug,
                    'ltc_claim_applications_slug' =>  $ltcClaimapp->ltc_claim_applications_slug,
                    'employee_slug' => $employeeSlug,
                    'ltc_claim_id' => $ltc_id,
                    'misc_type' => $Data['type'],
                    'claim_amount' => $Data['amount'],
                    'status' => 0, 
                    'claim_date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                    ];

                   
                    if ($request->hasFile("misc_files_{$index}")) {

                        foreach ($request->file("misc_files_{$index}") as $file) {
                        $filePath = $file->store('mimes/travel_management/ltc/miscellaneous');
                        
                        $FilesData[] = [
                            'ltc_files_slug' =>Str::slug(rand().rand()),
                            'type' => 'miscellaneous',
                            'employee_slug' => $employeeSlug,
                            'file_type' => $file->getClientOriginalExtension(),
                            'file_path' => $filePath,
                            'ltc_claim_id' => $ltc_id,
                            'claim_date' => date('Y-m-d H:i:s'),
                            'status' => 0,
                            'fileable_id' => $miscClaimSlug, 
                            'fileable_type' => LtcMiscellaneousExp::class,
                            'ltc_claim_applications_slug' =>  $ltcClaimapp->ltc_claim_applications_slug,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];

                            
                    }
                }

                }

                LtcMiscellaneousExp::insert($ltcMiscData);
                LtcFiles::insert($FilesData);
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

    // public function changeLTCStatusToManagerApprovRejectService($status,$ltcSlug,$ltcAppSlug,$page){
    //         $empSlug=Auth::guard('admin')->user()->employee_slug;      
    //         $ltcslugarray=explode("-", $ltcSlug);
    //     if($ltcslugarray[1]=='ltc'){
    //         $updateStatus= LtcClaim::where('ltc_claim_slug', $ltcslugarray[0])->update(['status' => $status,'modified'=>0]);
    //     }elseif($ltcslugarray[1]=='ltcmis'){
    //         $updateStatus= LtcMiscellaneousExp::where('ltc_miscellaneous_slug', $ltcslugarray[0])->update(['status' => $status,'modified'=>0]);
    //     }    

    //     $result = LtcClaimApplication::leftJoin('ltc_claims', 'ltc_claim_applications.ltc_claim_applications_slug', '=', 'ltc_claims.ltc_claim_applications_slug')
    //             ->leftJoin('ltc_miscellaneous_exps', 'ltc_claim_applications.ltc_claim_applications_slug', '=', 'ltc_miscellaneous_exps.ltc_claim_applications_slug')
    //             ->select(DB::raw("
    //                 COUNT(DISTINCT ltc_claims.ltc_claim_slug) as total_claims,
    //                 COUNT(CASE WHEN ltc_claims.status = '1' THEN ltc_claims.status END) as claims_status_1,
    //                 COUNT(CASE WHEN ltc_claims.status = '2' THEN ltc_claims.status END) as claims_status_2,
    //                 COUNT(CASE WHEN ltc_claims.status = '4' THEN ltc_claims.status END) as claims_status_4,
    //                 COUNT(CASE WHEN ltc_claims.status = '5' THEN ltc_claims.status END) as claims_status_5,
    //                 COUNT(CASE WHEN ltc_claims.status = '8' THEN ltc_claims.status END) as claims_status_8,
    //                 MAX(ltc_miscellaneous_exps.status) as exp_status
    //             "))
    //             ->where('ltc_claim_applications.ltc_claim_applications_slug', $ltcAppSlug)
    //             ->groupBy('ltc_claim_applications.ltc_claim_applications_slug')
    //             ->get();

    //     $ltcClaimApp=LtcClaimApplication::where('ltc_claim_applications.ltc_claim_applications_slug', $ltcAppSlug);
                   
    //     if ($result) {
    //            $status = 0; 
                
    //            if ($result[0]['total_claims'] == $result[0]['claims_status_1'] && $result[0]['exp_status'] == 1) {
    //                 $status = 1; 
    //                 $ltcClaimApp->update(['status' => $status, 'manager_approved_by' => $empSlug]);
    //             } elseif (($result[0]['total_claims'] == $result[0]['claims_status_2'] && $result[0]['exp_status'] == 2) || $result[0]['total_claims'] != $result[0]['claims_status_2'] && $result[0]['claims_status_2']!=0 || $result[0]['exp_status'] == 2 ||($result[0]['total_claims'] == $result[0]['claims_status_2'] && $result[0]['exp_status'] != 2)) {
    //                 $status = 2;
    //                 $ltcClaimApp->update(['status' => $status, 'manager_approved_by' => $empSlug]);
    //             } 
    //             elseif ($result[0]['total_claims'] == $result[0]['claims_status_4'] && $result[0]['exp_status'] == 4) {
    //                 $status = 4;
    //                 $ltcClaimApp->update(['status' => $status, 'hr_approved_by' => $empSlug]);
    //             } elseif (($result[0]['total_claims'] == $result[0]['claims_status_5'] && $result[0]['exp_status'] == 5) || $result[0]['total_claims'] != $result[0]['claims_status_5'] && $result[0]['claims_status_5']!=0 || $result[0]['exp_status'] == 5||($result[0]['total_claims'] == $result[0]['claims_status_5'] && $result[0]['exp_status'] != 5)){
                    
    //                 $status = 5;
    //                 $ltcClaimApp->update(['status' => $status, 'hr_approved_by' => $empSlug]);
    //             } elseif (($result[0]['total_claims'] == $result[0]['claims_status_8'] && $result[0]['exp_status'] == 8) || $result[0]['total_claims'] != $result[0]['claims_status_8'] && $result[0]['claims_status_8']!=0 || $result[0]['exp_status'] == 8||($result[0]['total_claims'] == $result[0]['claims_status_8'] && $result[0]['exp_status'] != 8)){
    //                 $status = 8;
    //                 $ltcClaimApp->update(['status' => $status, 'accountdep_approved_by' => $empSlug]);
    //             }
    //             // else {
    //             //     $status = 0; 
    //             //     $ltcClaimApp->update(['status' => $status,$page.'_approved_by' => null]);
    //             // }
              
    //             // LtcClaimApplication::where('ltc_claim_applications.ltc_claim_applications_slug', $ltcAppSlug)
    //             // ->update(['status' => $status, 'manager_approved_by' => $status === 0 && $page == 'manager'? null : $empSlug,
    //             //    'hr_approved_by' =>$status === 4 && $page == 'hr'? null : $empSlug,]);

    //             $overallstatus = LtcClaimApplication::with([
    //                 'manager_name:employee_slug,full_name',
    //                 'hr_name:employee_slug,full_name',
    //             ])->where('ltc_claim_applications_slug', $ltcAppSlug)
    //             ->select('status', 'manager_approved_by','hr_approved_by')
    //             ->get(); 
    //         }

    //     if($updateStatus){
    //         return $overallstatus;
    //     }
    // }

    // public function changeStatusToPayed($status,$ltcappslug){

    //     $empSlug=Auth::guard('admin')->user()->employee_slug;

    //     DB::transaction(function () use ($status,$ltcappslug,$empSlug) {
            
    //     LtcClaim::where('ltc_claim_id',$ltcappslug)->update(['status' => $status]);

    //     LtcMiscellaneousExp::where('ltc_claim_id',$ltcappslug)->update(['status' => $status]);

    //     LtcClaimApplication::where('ltc_claim_id',$ltcappslug)->update(['status' => $status,'payment_by'=> $empSlug]);

    //      });

    //     $ltcapp = LtcClaimApplication::where('ltc_claim_id',$ltcappslug)
    //      ->first();
          
    //    return $ltcapp;
    // }

    // public function ltcAppUpdate($request){
    // foreach ($request->input('date', []) as $index => $date) {
 
    //     LtcClaim::where('ltc_claim_slug', $request->input('ltc_claim_slug')[$index])->update([
    //         'date' => $date,
    //         'mode_of_transport' => $request->input('mode_of_transport')[$index],
    //         'opening_meter' => $request->input('opening_meter')[$index],
    //         'closing_meter' => $request->input('closing_meter')[$index],
    //         'total_km' => $request->input('total_km')[$index],
    //         'place_visited' => $request->input('place_visited')[$index],
    //         'claim_amount' => $request->input('claim_amount')[$index],
    //         'lunch_exp' => $request->input('lunch_exp')[$index],
    //         'fuel_exp' => $request->input('fuel_exp')[$index],
    //         'toll_charge' => $request->input('toll_charge')[$index],
    //         'modified'=> 1,
    //     ]);
   
    //    }

    //    if($request->input('ltc_miscellaneous_slug')){
    //     LtcMiscellaneousExp::where('ltc_miscellaneous_slug', $request->input('ltc_miscellaneous_slug'))->update([
    //         'courier_bill' => $request->input('courier_bill'),
    //         'xerox_stationary' => $request->input('xerox_stationary'),
    //         'office_expense' => $request->input('office_expense'),
    //         'monthly_mobile_bills' => $request->input('monthly_mobile_bills'),
    //         'modified'=> 1,
    //         'remarks' => $request->input('remarks'),
    //        ]);
    //    }

    //    $totalClaims = LtcClaim::whereIn('ltc_claim_applications_slug', [$request->input('ltc_claim_applications_slug')])
    //    ->sum(\DB::raw('claim_amount + lunch_exp + fuel_exp + toll_charge'));

    //    $totalMiscellaneous = LtcMiscellaneousExp::where('ltc_claim_applications_slug', $request->input('ltc_claim_applications_slug'))
    //         ->sum(\DB::raw('courier_bill + xerox_stationary + office_expense + monthly_mobile_bills'));

    //    $ltcClaimApplication = LtcClaimApplication::where('ltc_claim_applications_slug',$request->input('ltc_claim_applications_slug'));
     
    //     $ltcClaimApplication->update([
    //         'total_claim_amount' => $totalClaims + $totalMiscellaneous,
    //     ]);

    // }

    public function fetchGrade($employeeSlug){ //movetoservice
      
        $designation = Employee::with(['designation_department','department'])->where('employee_slug',$employeeSlug)->first();

        $department = $designation["department"]->name =='Sales' ? 'Sales' : 'Others';

        $grade = Grade::where('department', $department)->where('designation',$designation["designation_department"]->designation_name)->select('grade')->first();
                
       return $grade;
    }

    public function modeOfTransport($grade){ //movetoservice

       $modeoftravel = LocalConveyance::where('grade',$grade)->select('id','conveyance_type','conveyance')->get();
       return $modeoftravel;
        
    }

    // public function calculateltcExpense($openingMeter,$closingMeter,$modeOfTransport){

    //     $totalKm = $closingMeter - $openingMeter;

    //     if ($totalKm < 0) {
    //         return response()->json(['error' => 'Closing meter should be greater than opening meter'], 400);
    //     }

    //     $ratePerKm = $this->getTransportRate($modeOfTransport);

    //     $claimAmount = $totalKm * $ratePerKm;

    //     return response()->json([
    //         'total_km' => $totalKm,
    //         'claim_amount' => number_format($claimAmount, 2)
    //     ]);

    // }

    // private function getTransportRate(string $modeOfTransport): float
    // {
    //     return self::TRANSPORT_RATES[$modeOfTransport];
    // }

    // public function mobileBill($grade){

    //     return MobileExpense::where('grade',$grade)->select('expense')->first();

    // }   
    
    private function formatTravelEntries($travelClaims,$travelFiles,$ltcClaimId){
        $filteredClaims = $travelClaims->where('ltc_claim_id', $ltcClaimId);
        return $filteredClaims->map(function ($claim) use ($travelFiles) {
            return [
                'modeOfTransport' => $claim->mode_of_transport ?? '',
                'typeOfTransport' => $claim->type_of_transport ?? '', 
                'startingMeter'   => $claim->opening_meter ?? '', 
                'closingMeter'    => $claim->closing_meter ?? '', 
                'totalKms'        => $claim->total_km ?? '', 
                'tollCharges'     => $claim->toll_charge ?? '', 
                'fuelCharges'     => $claim->claim_amount ?? '', 
                'placesVisited'   => $claim->place_visited ?? '', 
                'files'           => $this->formatFiles($travelFiles->where('fileable_id',$claim->ltc_travel_claims_slug))??[]  
            ];
        })->values()->toArray();
    }

    private function formatFiles($files){
        return $files->map(function ($file) {
            return [
                'type'      => $file->file_type,
                'file_path' => $file->file_path,
                'timestamp' => strtotime($file->created_at)
            ];
        })->values()->toArray();
    }

    private function formatMiscExpenses($miscExpenses,$miscFiles,$ltcClaimId){
        $filteredmiscExpenses = $miscExpenses->where('ltc_claim_id', $ltcClaimId);
        return $filteredmiscExpenses->map(function ($misc) use ($miscFiles){
            return [
                'type'   => $misc->misc_type ?? '',
                'amount' => $misc->claim_amount ?? '0.00',
                'files'  => $this->formatFiles($miscFiles->where('fileable_id', $misc->ltc_miscellaneous_slug))??[]  
            ];
        })->values()->toArray();
    }

    private function travelApplicationStatus($result,$manager=null,$hr=null,$payed_by=null){
        $status = match ($result) {
            0 => 'Not Yet Reviewed By Manager',
            1 => 'Accepted By Manager ' . (isset($manager) ? $manager : ''),
            2 => 'Rejected By Manager',
            3 => 'Amount Paid By ' . (isset($payed_by) ? $payed_by : ''),
            4 => 'Approved By HR '. (isset($hr) ? $hr : ''),
            5 => 'Rejected By HR',
            // 6 => 'Case Clear By Accounts',
            // 7 => 'Case Closed',
            8 => 'Rejected By Accounts',
            default => 'Something Wrong',
            };
        return $status;
    }   
    
    private function calculateLtcTotalAmount($travelClaims, $miscExpenses,$foodExpenses,$ltcClaimId){
        $filteredTravelClaims = $travelClaims->where('ltc_claim_id', $ltcClaimId);
        $filteredMiscClaims = $miscExpenses->where('ltc_claim_id', $ltcClaimId);

        $totalTravelClaimExpenses =   $filteredTravelClaims->reduce(function ($carry, $claim) {
            return $carry + 
                (float)($claim->claim_amount ?? 0) + 
                (float)($claim->toll_charge ?? 0);
        }, 0);
    
        $totalMiscClaimExpenses =    $filteredMiscClaims->reduce(function ($carry, $claim) {
            return $carry + 
                (float)($claim->claim_amount ?? 0);
        }, 0);
    
         return $totalTravelClaimExpenses + $totalMiscClaimExpenses + $foodExpenses;
    }


}
?>
