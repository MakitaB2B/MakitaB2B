<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LtcFiles extends Model
{
    use HasFactory;

    protected $fillable = ['type','file_type', 'file_path', 'ltc_claim_id', 'claim_date','status','fileable_id', 'fileable_type'];

    public function fileable()
    {
        return $this->morphTo();
    }
}









// public function createLtcClaim($request, $employeeSlug, $ltc_id, $status) {
//     try {
//         return DB::transaction(function () use ($request, $employeeSlug, $ltc_id, $status) {
//             $teamDetails = TeamMembers::WHERE('team_member', '=', $employeeSlug)->get(['team_owner']);
//             $teamManager = count($teamDetails) > 0 ? $teamDetails[0]->team_owner : null;

//             $timeInfo = $request->input('timeInfo') ? json_decode($request->input('timeInfo'), true) : [];
//             $foodExpense = $request->input('foodExpense') ? json_decode($request->input('foodExpense'), true) : [];
//             $travelEntries = $request->input('travelEntries') ? json_decode($request->input('travelEntries'), true) : [];
//             $miscExpenses = $request->input('miscExpenses') ? json_decode($request->input('miscExpenses'), true) : [];

//             $ltcFoodClaim = new LtcFoodClaim([
//                 'ltc_food_claims_slug' => Str::slug(rand().rand()),
//                 'ltc_claim_applications_slug' => null,
//                 'ltc_claim_id' => $ltc_id,     
//                 'employee_slug' => $employeeSlug,
//                 'ltc_date' => $timeInfo["date"],
//                 'ltc_day' => $timeInfo["dayType"],
//                 'claim_date' => date('Y-m-d H:i:s'),
//                 'in_time' => $timeInfo["date"]." ".$timeInfo["inTime"]["hours"].":".$timeInfo["inTime"]["minutes"],
//                 'out_time' => $timeInfo["date"]." ".$timeInfo["outTime"]["hours"].":".$timeInfo["outTime"]["minutes"],
//                 'food_exp'=> $foodExpense["breakfast"]["amount"] ?? 0,
//                 'food_exp_bill' => $request->hasFile("breakfast_files") ? $request->file("breakfast_files")[0]->store('mimes/travel_management/ltc/food_info') : null,
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ]);
//             $ltcFoodClaim->save();

//             $travelClaimsData = [];
//             $travelFilesData = [];
            
//             foreach ($travelEntries as $index => $data) {
//                 $travelClaimSlug = Str::slug(rand().rand());
                
//                 $travelClaimsData[] = [
//                     'ltc_travel_claims_slug' => $travelClaimSlug,
//                     'ltc_claim_applications_slug' => null,
//                     'ltc_claim_id' => $ltc_id,
//                     'mode_of_transport'=> $data["modeOfTransport"],
//                     'employee_slug' => $employeeSlug,
//                     'type_of_transport' => $data["typeOfTransport"],
//                     'claim_date' => date('Y-m-d H:i:s'),
//                     'place_visited' => $data["placesVisited"] ?? null,          
//                     'opening_meter' => $data["startingMeter"] ?? 0,         
//                     'demo_van_no'=>  null,
//                     'closing_meter'=> $data["closingMeter"] ?? 0,  
//                     'total_km' => $data["totalKms"] ?? 0,                                                
//                     'toll_charge' => $data["tollCharges"] ?? 0,                                                   
//                     'claim_amount' => $data["fuelCharges"] ?? 0,
//                     'created_at' => now(),
//                     'updated_at' => now()
//                 ];

//                 if ($request->hasFile("travel_receipts.{$index}")) {
//                     foreach ($request->file("travel_receipts.{$index}") as $file) {
//                         $filePath = $file->store('mimes/travel_management/ltc/travel_receipts');
                        
//                         $travelFilesData[] = [
//                             'type' => 'travel_receipt',
//                             'file_type' => $file->getClientOriginalExtension(),
//                             'file_path' => $filePath,
//                             'ltc_claim_id' => $ltc_id,
//                             'claim_date' => date('Y-m-d H:i:s'),
//                             'status' => 0,
//                             'reference_slug' => $travelClaimSlug, 
//                             'fileable_type' => LtcTravelClaim::class
//                         ];
//                     }
//                 }
//             }

//             if (!empty($travelClaimsData)) {
//                 LtcTravelClaim::insert($travelClaimsData);
//             }

//             $filteredExpenses = array_filter($miscExpenses, fn($expense) => 
//                 !empty($expense['type']) && !empty($expense['amount']) && $expense['amount'] > 0
//             );

//             $miscExpensesData = [];
//             $miscFilesData = [];

//             foreach ($filteredExpenses as $index => $expense) {
//                 $miscSlug = Str::slug(rand().rand());
                
//                 $miscExpensesData[] = [
//                     'ltc_miscellaneous_slug' => $miscSlug,
//                     'ltc_claim_applications_slug' => null,
//                     'employee_slug' => $employeeSlug,
//                     'ltc_claim_id' => $ltc_id,
//                     'misc_type' => $expense['type'],
//                     'claim_amount' => $expense['amount'],
//                     'status' => 0,
//                     'claim_date' => date('Y-m-d H:i:s'),
//                     'created_at' => now(),
//                     'updated_at' => now()
//                 ];

//                 if ($request->hasFile("misc_receipts.{$index}")) {
//                     foreach ($request->file("misc_receipts.{$index}") as $file) {
//                         $filePath = $file->store('mimes/travel_management/ltc/misc_receipts');
                        
//                         $miscFilesData[] = [
//                             'type' => 'misc_receipt',
//                             'file_type' => $file->getClientOriginalExtension(),
//                             'file_path' => $filePath,
//                             'ltc_claim_id' => $ltc_id,
//                             'claim_date' => date('Y-m-d H:i:s'),
//                             'status' => 0,
//                             'reference_slug' => $miscSlug, 
//                             'fileable_type' => LtcMiscellaneousExp::class
//                         ];
//                     }
//                 }
//             }

//             if (!empty($miscExpensesData)) {
//                 LtcMiscellaneousExp::insert($miscExpensesData);
//             }

//             if (!empty($travelFilesData)) {
               
//                 $travelClaimMappings = LtcTravelClaim::whereIn('ltc_travel_claims_slug', 
//                     array_column($travelClaimsData, 'ltc_travel_claims_slug'))
//                     ->pluck('id', 'ltc_travel_claims_slug')
//                     ->toArray();

//                 foreach ($travelFilesData as &$fileData) {
//                     $fileData['fileable_id'] = $travelClaimMappings[$fileData['reference_slug']] ?? null;
//                     unset($fileData['reference_slug']);
//                 }

//                 LtcFiles::insert($travelFilesData);
//             }

//             if (!empty($miscFilesData)) {
//                 $miscExpenseMappings = LtcMiscellaneousExp::whereIn('ltc_miscellaneous_slug', 
//                     array_column($miscExpensesData, 'ltc_miscellaneous_slug'))
//                     ->pluck('id', 'ltc_miscellaneous_slug')
//                     ->toArray();

//                 foreach ($miscFilesData as &$fileData) {
//                     $fileData['fileable_id'] = $miscExpenseMappings[$fileData['reference_slug']] ?? null;
//                     unset($fileData['reference_slug']);
//                 }

//                 LtcFiles::insert($miscFilesData);
//             }

//             return true;
//         });
//     } catch (Exception $e) {
//         \Log::error('LTC Claim Creation Error: ' . $e->getMessage());
//         return false;
//     }
// }