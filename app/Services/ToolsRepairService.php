<?php
namespace App\Services;
use App\Models\Admin\ToolsService;
use App\Models\Admin\FscExecutive;
use App\Models\Admin\FactoryServiceCenters;
use App\Models\Admin\ToolserviceCostestimationCxs;
use App\Models\Admin\Employee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class ToolsRepairService{
    public function getAllToolsServices(){
        return ToolsService::with(['fscBranch:center_name,fsc_slug','waranty:machine_serial_number,warranty_expiry_date'])->orderBy('status','asc')->get();
    }
    public function getToolsServicesByRepairer($dataOparateEmpSlug){
        return ToolsService::join('fsc_executives','fsc_executives.fsc_slug','=','tools_services.service_center')->where('fsc_executives.employee_slug', '=', $dataOparateEmpSlug)->get();
    }
    public function findToolsServiceBySlug($slug){
        return ToolsService::where(['sr_slug'=>$slug])->get();
    }
    public function createOrUpdateToolsService($id,$request,$slug,$trn,$srDate,$delerCXName,$contactNumber,$model,$toolsSlNo,$status,$cxSlug){
        $operate=ToolsService::updateOrCreate(
            ['id' =>$id],
            ['cx_slug'=>$cxSlug,'trn'=> $trn,'sr_date'=>$srDate,'tools_issue'=>$request->tools_issue,
            'service_center'=>$request->service_center,'repairer'=>$request->repairer,
            'delear_customer_name'=>$delerCXName,'contact_number'=>$contactNumber,'model'=>$model,
            'tools_sl_no'=>$toolsSlNo,'receive_date_time'=>$srDate,
            'estimation_date_time'=>$request->estimation_date_time,'duration_a_b'=>$request->duration_a_b,'cost_estimation'=>$request->cost_estimation,
            'est_date_confirm_cx'=>$request->est_date_confirm_cx,'repair_complete_date_time'=>$request->receive_date_time,'duration_c_d'=>$request->duration_c_d,
            'status'=>$status,'total_hour_for_repair'=>$request->total_hour_for_repair,'repair_parts_details'=>$request->repair_parts_details,
            'reason_for_over_48h'=>$request->reason_for_over_48h,'part_number_reason_for_delay'=>$request->part_number_reason_for_delay,'sr_slug'=>$slug]
         );
         if($operate){
            return true;
         }
    }
    public function sendRepairCompletionSMS($srSlug,$srRepairCompletionDT,$repairPartsDetails,$durationCD,$status,$totalHoursOfRepair){
        $operate=DB::table('tools_services')->where('sr_slug', $srSlug)->update(['repair_complete_date_time' => $srRepairCompletionDT, 'repair_parts_details'=>$repairPartsDetails,'duration_c_d'=>$durationCD,'status'=>$status,'total_hour_for_repair'=>$totalHoursOfRepair]);
        if($operate){
            return true;
         }
    }
    public function findServiceExecutivesBySC($sc){
        return FscExecutive::join('employees','employees.employee_slug','=','fsc_executives.employee_slug')->where('fsc_executives.fsc_slug', '=', $sc)->get(['employees.full_name','employees.employee_slug']);
    }
    public function getServiceCenterBySlug($fscSlug){
        return FactoryServiceCenters::where(['fsc_slug'=>$fscSlug])->get(['center_name','phone']);
    }
    public function updateToolsRepairCostEstimation($serviceSlug,$request,$dataOparateEmpSlug,$srCostEstimationDT,$totalCostEstimation,$durationAB){
        $srCostEstimationFile=$request->file('sr_costest_file')->store('mimes/warranty/tools_sr_cost_estimation');
        $operate=ToolsService::where('sr_slug', $serviceSlug)->update(['costestimation_file' => $srCostEstimationFile,
        'estimation_date_time' => $srCostEstimationDT, 'cost_estimation'=>$totalCostEstimation, 'duration_a_b'=>$durationAB, 'status'=>2]);
         if($operate){
            return true;
         }
    }
    public function toolsHandoverService($handOverDateTime,$status,$srSlug){
        $operate=ToolsService::where('sr_slug', $srSlug)->update(['handover_date_time' => $handOverDateTime, 'status'=>$status]);
        if($operate){
            return true;
         }
    }
    public function closeSRService($decripedSRSlug,$status,$srClosingReason){
        $operate=ToolsService::where('sr_slug', $decripedSRSlug)->update(['status' => $status,'sr_closing_reason'=>$srClosingReason]);
        if($operate){
            return true;
         }
    }
    public function reasonOver48HoursService($decripedSRSlug,$reasonOver48Hour,$partNumberIfReasonDelay){
        $operate=ToolsService::where('sr_slug', $decripedSRSlug)->update(['reason_for_over_48h' => $reasonOver48Hour,'part_number_reason_for_delay'=>$partNumberIfReasonDelay]);
        if($operate){
            return true;
        }
    }
    public function findEmployeeBySlug($empSlug){
        return Employee::where(['employee_slug'=>$empSlug])->get(['full_name']);
    }
    public function getAllServiceCenters(){
        return FactoryServiceCenters::get(['center_name','fsc_slug']);
    }
}
?>
