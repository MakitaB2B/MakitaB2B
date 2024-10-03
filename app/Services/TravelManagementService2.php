<?php
namespace App\Services;
use App\Models\Admin\BtaApplication;
use App\Models\Admin\BtaExpensesBreakups;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;




class TravelManagementService{
    // public function getAllTeamsWithOwner(){
    //     return Team::with(['employee:employee_slug,full_name,employee_no'])->select('team_name','team_owner','team_slug')->get();
    // }
    // public function getTeamsByOwner($dataOparateEmpSlug){
    //     return Team::with(['employee:employee_slug,full_name,employee_no'])->where(['team_owner'=>$dataOparateEmpSlug])->select('team_name','team_owner','team_slug')->get();
    // }
    // public function findTeamBySlug($slug){
    //     return Team::where(['team_slug'=>$slug])->get();
    // }
    // public function createOrUpdateTeams($id,$request,$slug,$dataOparateEmpSlug,$teamOwner){
    //     $operate=Team::updateOrCreate(
    //         ['id' =>$id],
    //         ['team_name'=> $request->name,'team_owner'=>$teamOwner,'updated_by'=>$dataOparateEmpSlug,'team_slug'=>$slug]
    //      );
    //      if($operate){
    //         return true;
    //      }
    // }
    // public function teamMembersByTeam($teamSlug){
    //     return TeamMembers::where(['team_slug'=>$teamSlug])->get();
    // }
    // public function fetchAllActiveEmployee(){
    //     return DB::table('employees')->where(['status'=>1])->get(['employee_no','full_name','employee_slug']);
    // }
    public function createBTAApplication($request,$btaSlug,$applicantSlug,$travelID,$status){

        // $travelManagementApplicationInsert[] = [
        //     'emp_slug' => $applicantSlug,
        //     'starting_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->bta_starting_datetime),
        //     'ending_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->bta_ending_datetime),
        //     'number_of_days' => $request->total_trip_days,
        //     'place_of_visit' => $request->bta_place_of_visit,
        //     'purpose_of_visit' => $request->purpose_of_visit,
        //     'total_expenses' => 5000,
        //     'bta_slug' => $btaSlug,
        //     'status' => $status,
        //     'created_by' => $applicantSlug,
        // ];

        // Execute the insert
        // BtaApplication::insert($travelManagementApplicationInsert);



        // $btaApplication = new \App\Models\Admin\BtaApplication([
        //     'emp_slug' => $applicantSlug,
        //     'starting_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->starting_date_time),
        //     'ending_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->bta_ending_datetime),
        //     'number_of_days' => $request->total_trip_days,
        //     'place_of_visit' => $request->bta_place_of_visit,
        //     'purpose_of_visit' => $request->purpose_of_visit,
        //     'total_expenses' => 5000,
        //     'bta_slug' => $btaSlug,
        //     'status' => $status,
        //     'created_by' => $applicantSlug,
        // ]);

        // $btaApplication->save();
        // return true;


        // $firstModelData[] = [
        //     'emp_slug' => $applicantSlug,
        //     'starting_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->starting_date_time),
        //     'ending_date_time' => Carbon::createFromFormat('m/d/Y h:i A', $request->bta_ending_datetime),
        //     'number_of_days' => $request->total_trip_days,
        //     'place_of_visit' => $request->bta_place_of_visit,
        //     'purpose_of_visit' => $request->purpose_of_visit,
        //     'total_expenses' => 5000,
        //     'bta_slug' => $btaSlug,
        //     'status' => $status,
        //     'created_by' => $applicantSlug,
        // ];

        // echo $request->bta_expbreakup_date;
        // echo '<br>';
        // echo $request->trip_place_of_visit;
        // echo '<br>';
        // echo $request->journey_fare;
        // echo '<br>';
        // echo $request->accommodation;
        // echo '<br>';
        // echo $request->conveyance;
        // echo '<br>';
        // echo $request->amount;
        // echo '<br>';
        // die();

        // $secondModelData[] = [
        //     'bta_slug' => 526524554,
        //     'applicant_emp_slug' => $applicantSlug,
        //     'date' => $request->bta_expbreakup_date,
        //     'place_to_visit' => $request->trip_place_of_visit,
        //     'journey_fare' => $request->journey_fare,
        //     'accomodation' => $request->accommodation,
        //     'conveyance' => $request->conveyance,
        //     'amount' => $request->amount,
        // ];

        //  $btaExpBreakUp = new \App\Models\Admin\BtaExpensesBreakups([
        //     'bta_slug' => rand(),
        //     'applicant_emp_slug' => $applicantSlug,
        //     'date' => $request->bta_expbreakup_date,
        //     'place_to_visit' => $request->trip_place_of_visit,
        //     'journey_fare' => $request->journey_fare,
        //     'accomodation' => $request->accommodation,
        //     'conveyance' => $request->conveyance,
        //     'amount' => $request->amount,
        //     'approval_status' => 0,
        //     'btaexpbreakup_slug' => rand().rand(),
        // ]);

        // $btaExpBreakUp->save();

        try {
            DB::transaction(function () use ($request, $applicantSlug, $btaSlug, $status) {
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
                    'created_by' => $applicantSlug,
                ]);

                $btaApplication->save();

                // Step 2: Create and save the BtaExpensesBreakups using the ID from BtaApplication
                // $btaExpBreakUp = new BtaExpensesBreakups([
                //     'bta_slug' => $btaApplication->bta_slug,  // Use the slug from the BtaApplication
                //     'applicant_emp_slug' => $applicantSlug,
                //     'date' => $request->bta_expbreakup_date,
                //     'place_to_visit' => $request->trip_place_of_visit,
                //     'journey_fare' => $request->journey_fare,
                //     'accomodation' => $request->accommodation,
                //     'conveyance' => $request->conveyance,
                //     'amount' => $request->amount,
                //     'approval_status' => 0,
                //     'btaexpbreakup_slug' => rand().rand(),
                // ]);

                // $btaExpBreakUp->save();

                $btaExpensesBreakupArr=$request->post("bta_expbreakup_date");
                $arrayCount=count($btaExpensesBreakupArr);

                for($i=0;$i<$arrayCount;$i++){
                    // $btaExpBreakUp = new BtaExpensesBreakups([
                    //     'bta_slug' => $btaApplication->bta_slug,  // Use the slug from the BtaApplication
                    //     'applicant_emp_slug' => $applicantSlug,
                    //     'date' => $expenseData['bta_expbreakup_date'][$i],
                    //     'place_to_visit' => $expenseData['trip_place_of_visit'][$i],
                    //     'journey_fare' => $expenseData['journey_fare'][$i],
                    //     'accomodation' => $expenseData['accommodation'][$i],
                    //     'conveyance' => $expenseData['conveyance'][$i],
                    //     'amount' => $expenseData['amount'][$i],
                    //     'approval_status' => 0,
                    //     'btaexpbreakup_slug' => rand().rand(),
                    // ]);

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

            });

            // If successful
            // return response()->json(['message' => 'Data inserted successfully'], 200);
            return true;

        } catch (Exception $e) {
            // Handle the exception and return an error response
            // return response()->json(['message' => 'Failed to insert data', 'error' => $e->getMessage()], 500);
            return false;
        }


        // try {
        //     DB::transaction(function () use ($firstModelData, $secondModelData) {
        //         // Insert data into the first table
        //         $firstRecord = BtaApplication::create($firstModelData);

        //         // Retrieve the ID of the inserted record
        //         $firstModelId = $firstRecord->id;

        //         // Insert data into the second table using the ID from the first table
        //         // $secondModelData['first_model_id'] = $firstModelId;
        //         BtaExpensesBreakups::create($secondModelData);
        //     });

        //     // If the transaction is successful, you can proceed with other actions here
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
