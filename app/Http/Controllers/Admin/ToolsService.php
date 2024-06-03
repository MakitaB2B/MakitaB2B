<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ToolsRepairService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Traits\HasPermissionsTrait;
use App\Models\Admin\Sms;
use Carbon\Carbon;
use Auth;

class ToolsService extends Controller
{
    protected $toolsRepairService;
    public function __construct(ToolsRepairService $toolsRepairService){
        $this->toolsRepairService=$toolsRepairService;
    }
    public function index(){
        $role= Auth::guard('admin')->user()->hasRole('super-admin1944305928');
        if($role==true){
            $toolsService=$this->toolsRepairService->getAllToolsServices();
        }else{
            $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug;
            $toolsService=$this->toolsRepairService->getToolsServicesByRepairer($dataOparateEmpSlug);
        }
        return view('Admin.service_management',['toolsServiceList'=>$toolsService]);
    }
    public function manageServiceRequest($srSlug = ''){
        if ($srSlug > 0) {
            $decripedSRSlug = Crypt::decrypt($srSlug);
            $arr = $this->toolsRepairService->findToolsServiceBySlug($decripedSRSlug);
            $result['trn'] = $arr[0]->trn;
            $result['sr_date'] = $arr[0]->sr_date;
            $result['tools_issue'] = $arr[0]->tools_issue;
            $result['service_center'] = $arr[0]->service_center;
            $result['repairer'] = $arr[0]->repairer;
            $result['delear_customer_name'] = $arr[0]->delear_customer_name;
            $result['contact_number'] = $arr[0]->contact_number;
            $result['model'] = $arr[0]->model;
            $result['tools_sl_no'] = $arr[0]->tools_sl_no;
            $result['receive_date_time'] = $arr[0]->receive_date_time;
            $result['estimation_date_time'] = $arr[0]->estimation_date_time;
            $result['duration_a_b'] = $arr[0]->duration_a_b;
            $result['cost_estimation'] = $arr[0]->cost_estimation;
            $result['est_date_confirm_cx'] = $arr[0]->est_date_confirm_cx;
            $result['repair_complete_date_time'] = $arr[0]->repair_complete_date_time;
            $result['reason_if_rejected']=$arr[0]->reason_if_rejected;
            $result['duration_c_d'] = $arr[0]->duration_c_d;
            $result['handover_date_time'] = $arr[0]->handover_date_time;
            $result['total_hour_for_repair'] = $arr[0]->total_hour_for_repair;
            $result['repair_parts_details'] = $arr[0]->repair_parts_details;
            $result['reason_for_over_48h'] = $arr[0]->reason_for_over_48h;
            $result['part_number_reason_for_delay'] = $arr[0]->part_number_reason_for_delay;
            $result['sr_slug'] = Crypt::encrypt($arr[0]->sr_slug);
            $result['srStatus']=$arr[0]->status;
            $result['sr_slug_raw'] = $arr[0]->sr_slug;
            if($result['srStatus']!=7){
            $result['service_executives']=$this->toolsRepairService->findServiceExecutivesBySC($arr[0]->service_center);
            }
            $result['service_center_assigned'] = $this->toolsRepairService->getServiceCenterBySlug($arr[0]->service_center);
            $result['costEstimationFile']=$arr[0]->costestimation_file;
            $result['sr_closing_reason']=$arr[0]->sr_closing_reason;
            if($result['srStatus']==7){
                $result['empDetails']= $this->toolsRepairService->findEmployeeBySlug($result['repairer']);
            }
        } else {
            echo "SR Slug is 0";
            die();
            // $result['state_slug'] = Crypt::encrypt(0);
        }
        return view('Admin.manage_service_request', $result);
     }
    public function createOrUpdateToolsService(Request $request){
        $decripedSlug= Crypt::decrypt($request->srSlug);
        if($decripedSlug>0){
            $rowData=$this->toolsRepairService->findToolsServiceBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $cxSlug=$rowData[0]->cx_slug;
            $slug=$rowData[0]->sr_slug;
            $trn=$rowData[0]->trn;
            $srDate=$rowData[0]->sr_date;
            $delerCXName=$rowData[0]->delear_customer_name;
            $contactNumber=$rowData[0]->contact_number;
            $model=$rowData[0]->model;
            $toolsSlNo=$rowData[0]->tools_sl_no;
            if($rowData[0]->repairer==null){
                $status=1;
            }else{
                $status=$rowData[0]->status;
            }
        }else{
            $id=0;
            $cxSlug=Auth::guard('customer')->user()->customer_slug;
            $slug=Str::slug(rand().rand());
            $trn=rand();
            $srDate=Carbon::now()->toDateTimeString();
            $delerCXName=$request->cx_name;
            $contactNumber=$request->cx_number;
            $model=$request->model_number;
            $toolsSlNo=$request->machine_sl_no;
            $status=0;
        }
        $data= $request->validate([
             'tools_issue'=>'required|min:5',
        ]);

         if($data){
            $createUpdateAction=$this->toolsRepairService->createOrUpdateToolsService($id,$request,$slug,$trn,$srDate,$delerCXName,$contactNumber,$model,$toolsSlNo,$status,$cxSlug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Tools Repair Service sucessfully updated';
                    if($rowData[0]->repairer==null && $request->has('repairer')){
                        $empDtls=$this->toolsRepairService->findEmployeeBySlug($request->repairer);
                        $repairName=$empDtls[0]->full_name;
                        $mobile=$contactNumber;
                        $message="Dear $delerCXName, SR $trn received for service, assigned to our executive $repairName. Collect back within 30 days-Makita Power Tools India";
                        Sms::sendSMS($message,$mobile);
                    }
                 }else{
                    if($decripedSlug==0 && $status==0){
                        $mobile=$contactNumber;
                        $message="Dear $delerCXName, Thank you for registering SR $trn, Please await confirmation of your SR acceptance by our service team -Makita Power Tools India";
                        Sms::sendSMS($message,$mobile);
                    }
                    $msg='Tools Repair Service sucessfully Created';
                 }
                $request->session()->flash('message',$msg);
                $incomingSource=Crypt::decrypt($request->incoming_source);
                if($incomingSource=='cx'){
                    $routeTo='cx-tools-repair-list';
                }else{
                    $routeTo='admin/service-management';
                }
                return redirect($routeTo);
            }
         }
     }
     public function createOrUpdateServiceCostEstimation(Request $request){
        $costEstSlug=Crypt::decrypt($request->cost_estslug);
        $status=2;
        if($costEstSlug==0){
            $data = $request->validate([
            'sr_costest_file' => 'required|mimes:pdf',
            ]);
            if($data){
                $serviceSlug=Crypt::decrypt($request->srslug_costest);
                $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug;

                $rowData=$this->toolsRepairService->findToolsServiceBySlug($serviceSlug);
                $srDt = Carbon::parse($rowData[0]->receive_date_time);
                $srCostEstimationDT=Carbon::now()->toDateTimeString();
                $parseSRCostEstDT = Carbon::parse($srCostEstimationDT);
                $durationAB = $srDt->diffInMinutes($parseSRCostEstDT);
                $totalCostEstimation=$request->cost_estimation;


                $createUpdateAction=$this->toolsRepairService->updateToolsRepairCostEstimation($serviceSlug,$request,$dataOparateEmpSlug,$srCostEstimationDT,$totalCostEstimation,$durationAB,$status);
                if($createUpdateAction){
                    if($costEstSlug>0){
                        $msg='Repair Estimation sucessfully updated';
                     }
                     else{
                        $empDtls=$this->toolsRepairService->findEmployeeBySlug($request->repairer);
                        $delerCXName=$rowData[0]->delear_customer_name;
                        $trn=$rowData[0]->trn;
                        $mobile=$rowData[0]->contact_number;
                        $encSRSlug=base64_encode($serviceSlug);
                        $srDate=Carbon::parse($rowData[0]->sr_date)->format('d M Y');
                        $message="Dear $delerCXName, Your SR $trn repair cost has been generated to approve or reject visit https://makita.ind.in/cxtoolsrepaircostestimation/$encSRSlug.
                        please collect the tools within 30 days from the SR Date-$srDate. Thank You - Makita Power Tools India PVT. LTD.";
                        Sms::sendSMS($message,$mobile);
                        $msg='Repair Estimation sucessfully sucessfully Send';
                     }
                    $request->session()->flash('message',$msg);
                    return redirect('admin/service-management');
                }
            }
        }
     }
     public function sendRepairCompletionSMS(Request $request){
        $srSlug=Crypt::decrypt($request->sr_repair_complete_slug);
        $srRepairCompletionDT=Carbon::now()->toDateTimeString();
        $status=5;

        $rowData=$this->toolsRepairService->findToolsServiceBySlug($srSlug);
        $edCx = Carbon::parse($rowData[0]->est_date_confirm_cx);
        $srCostEstimationDT=Carbon::now()->toDateTimeString();
        $parseSRCostEstDT = Carbon::parse($srRepairCompletionDT);
        $durationCD = $edCx->diffInMinutes($parseSRCostEstDT);
        $durationAB=$rowData[0]->duration_a_b;
        $totalHoursOfRepair= ($durationAB+$durationCD);
        $repairPartsDetails=$request->repair_parts_details;
        $updateRepairCompletionData=$this->toolsRepairService->sendRepairCompletionSMS($srSlug,$srRepairCompletionDT,$repairPartsDetails,$durationCD,$status,$totalHoursOfRepair);
        if($updateRepairCompletionData){
            $dealerCXName=$rowData[0]->delear_customer_name;
            $trn=$rowData[0]->trn;
            $srDate=Carbon::parse($rowData[0]->sr_date)->format('d M Y');
            $mobile=$rowData[0]->contact_number;
            $message="Dear $dealerCXName, SR $trn repair is complete. Please collect ASAP. note, tools should be collected within 30 days from the SR Date: $srDate. Makita Power Tools India";
            Sms::sendSMS($message,$mobile);
            $msg='Repair Completion Data sucessfully Inserted';
            $request->session()->flash('message',$msg);
            return redirect('admin/service-management');
        }
     }
     public function insertToolstHandOverData(Request $request){
        $handoverDateParse = Carbon::createFromFormat('m/d/Y h:i A', $request->handover_date_time);
        $handOverDateTime = $handoverDateParse->format('Y-m-d H:i:s');
        $status=6;
        $srSlug=Crypt::decrypt($request->srslug_hod);
        $dataOperator=$this->toolsRepairService->toolsHandoverService($handOverDateTime,$status,$srSlug);
        $msg='Tools Hand Over Data sucessfully Inserted';
        $request->session()->flash('message',$msg);
        return redirect('admin/service-management');
     }
     public function closeSR(Request $request){
        $decripedSRSlug=Crypt::decrypt($request->srslug_closesr);
        $srClosingReason=$request->sr_closing_reason;
        $rowData=$this->toolsRepairService->findToolsServiceBySlug($decripedSRSlug);
        $closingStatus=$rowData[0]->status;
        $status=7;
        $dataOperator=$this->toolsRepairService->closeSRService($decripedSRSlug,$status,$srClosingReason);
        if($dataOperator){
            if($closingStatus==4){
                $dealerCXName=$rowData[0]->delear_customer_name;
                $trn=$rowData[0]->trn;
                $mobile=$rowData[0]->contact_number;
                $message="Dear $dealerCXName, the unrepaired tool returned and SR $trn has been closed. Thank you, -Makita Power Tools India";
                Sms::sendSMS($message,$mobile);
            }if($closingStatus==6 && $rowData[0]->handover_date_time !=null){
                $dealerCXName=$rowData[0]->delear_customer_name;
                $trn=$rowData[0]->trn;
                $mobile=$rowData[0]->contact_number;
                $message="Dear $dealerCXName, your repaired tool has been returned and SR $trn has been closed.Thank you. Makita Power Tools India";
                Sms::sendSMS($message,$mobile);
            }
            $msg='Service Request Closed Sucessfully';
            $request->session()->flash('message',$msg);
            return redirect('admin/service-management');
        }
     }
     public function reasonOver48Hours(Request $request){
        $decripedSRSlug=Crypt::decrypt($request->srslug_reasonover48h);
        $reasonOver48Hour=$request->reason_over_48h;
        $partNumberIfReasonDelay=$request->part_number_if_reason_delay;
        $dataOperator=$this->toolsRepairService->reasonOver48HoursService($decripedSRSlug,$reasonOver48Hour,$partNumberIfReasonDelay);
        $msg='The Reason For Over 48 Hours Data Inserted Sucessfully';
        $request->session()->flash('message',$msg);
        return redirect('admin/service-management');
    }
}
