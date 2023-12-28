<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\EmployeeWorkExperienceService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Auth;

class EmployeeWorkExperienceController extends Controller
{
    protected $employeeWorkExperienceService;
    public function __construct(EmployeeWorkExperienceService $employeeWorkExperienceService){
        $this->employeeWorkExperienceService=$employeeWorkExperienceService;
    }
    public function manageEmployeeWorkExprience($employeeslug = '')
    {
        $decripedEmployeeslug = Crypt::decrypt($employeeslug);
        $empWorkExpData = $this->employeeWorkExperienceService->findEmployeeWorkExpByEmpSlug($decripedEmployeeslug);

        if (count($empWorkExpData) > 0) {
            $result['empWorkExpArray'] =$empWorkExpData;
            $result['emp_slug'] = $employeeslug;
            $result['asterisk'] = '';
            $result['required'] = '';
        } else {
            $result['empWorkExpArray'][0]['company_name']='';
            $result['empWorkExpArray'][0]['appointment_letter'] = '';
            $result['empWorkExpArray'][0]['relieving_letter'] = '';
            $result['empWorkExpArray'][0]['payslip_last_month'] = '';
            $result['empWorkExpArray'][0]['payslip_2nd_last_month'] = '';
            $result['empWorkExpArray'][0]['payslip_3rd_last_month'] = '';
            $result['empWorkExpArray'][0]['ewe_slug'] = '';
            $result['emp_slug'] = $employeeslug;
            $result['asterisk'] = '*';
            $result['required'] = 'required';
        }
        return view('Admin.manage_employee_workexp',$result);
    }
    public function manageEmployeeWorkExprienceProcess(Request $request){
        // $request->validate([
        //     'company_name.*'=>['required','string','max:255'],
        //     'appointment_letter'=>'required',
        //     'appointment_letter.*'=>'mimes:jpg,jpeg,png,pdf',
        //     'relieving_letter'=>'required',
        //     'relieving_letter.*'=>'mimes:jpg,jpeg,png,pdf',
        //     'payslip_last_month'=>'required',
        //     'payslip_last_month.*'=>'mimes:jpg,jpeg,png,pdf',
        //     'payslip_2nd_last_month'=>'required',
        //     'payslip_2nd_last_month.*'=>'mimes:jpg,jpeg,png,pdf',
        //     'payslip_3rd_last_month'=>'required',
        //     'payslip_3rd_last_month.*'=>'required|mimes:jpg,jpeg,png,pdf',
        // ]);
        $empSlug=Auth::guard('admin')->user()->employee_slug ;
        $companyNameArr=$request->post("company_name");
        $eweSlug=$request->post("ewe_slug");
        $arrayCount=count($companyNameArr);
        $empWorkExpArr=[];
        for($i=0;$i<$arrayCount;$i++){
            $empWorkExpArr['company_name']=$companyNameArr[$i];
            $empWorkExpArr['ewe_slug']=$eweSlug[$i];
            if($eweSlug[$i]!=''){
                $empWorkExpRecord = $this->employeeWorkExperienceService->findEmployeeWorkExpBySlug($eweSlug[$i]);
            }
            if($request->hasFile("appointment_letter.$i")){
                $empWorkExpArr['appointment_letter']=$request->file("appointment_letter.$i")->store('mimes/employee/workexp');
                if($eweSlug[$i]!=''){
                    $appointmentLetter=$empWorkExpRecord[0]->appointment_letter;
                    if(Storage::exists($appointmentLetter)){
                        Storage::delete($appointmentLetter);
                    }
                }
            }else{
                $empWorkExpArr['appointment_letter']=$empWorkExpRecord[0]->appointment_letter;
            }
            if($request->hasFile("relieving_letter.$i")){
                $empWorkExpArr['relieving_letter']=$request->file("relieving_letter.$i")->store('mimes/employee/workexp');
            }else{
                $empWorkExpArr['relieving_letter']=$empWorkExpRecord[0]->relieving_letter;
            }
            if($request->hasFile("payslip_last_month.$i")){
                $empWorkExpArr['payslip_last_month']=$request->file("payslip_last_month.$i")->store('mimes/employee/workexp');
            }else{
                $empWorkExpArr['payslip_last_month']=$empWorkExpRecord[0]->payslip_last_month;
            }
            if($request->hasFile("payslip_2nd_last_month.$i")){
                $empWorkExpArr['payslip_2nd_last_month']=$request->file("payslip_2nd_last_month.$i")->store('mimes/employee/workexp');
            }else{
                $empWorkExpArr['payslip_2nd_last_month']=$empWorkExpRecord[0]->payslip_2nd_last_month;
            }
            if($request->hasFile("payslip_3rd_last_month.$i")){
                $empWorkExpArr['payslip_3rd_last_month']=$request->file("payslip_3rd_last_month.$i")->store('mimes/employee/workexp');
            }else{
                $empWorkExpArr['payslip_3rd_last_month']=$empWorkExpRecord[0]->payslip_3rd_last_month;
            }
            $empWorkExpArr['emloyee_slug']=Crypt::decrypt($request->post('empslug'));
            $empWorkExpArr['ewe_slug']=Str::slug(time().rand().rand());
            $empWorkExpArr['updated_by']=$empSlug;
            $empWorkExpArr['updated_at']=date('Y-m-d H:i:s');
            if($eweSlug[$i]!=''){
                DB::table('employee_work_experiences')->where(['ewe_slug'=>$eweSlug[$i]])->update($empWorkExpArr);
            }else{
                $empWorkExpArr['created_at']=date('Y-m-d H:i:s');
                DB::table('employee_work_experiences')->insert($empWorkExpArr);
            }
        }
        $request->session()->flash('message','Employee Work Exprience Operation Sucessfull');
        return redirect('admin/employee/manage-employee-workexp/'.$request->post('empslug'));
    }
    public function employeeWorkExprienceDelete(Request $request,$eweSlug){
        $decripedEWEslug = Crypt::decrypt($eweSlug);
        $empWorkExpRecord = $this->employeeWorkExperienceService->findEmployeeWorkExpBySlug($decripedEWEslug);
        $appointmentLetter=$empWorkExpRecord[0]->appointment_letter;
            if(Storage::exists($appointmentLetter)){
                Storage::delete($appointmentLetter);
            }
        $relievingLetter=$empWorkExpRecord[0]->relieving_letter;
            if(Storage::exists($relievingLetter)){
                Storage::delete($relievingLetter);
            }
        $payslipLastMonth=$empWorkExpRecord[0]->payslip_last_month;
            if(Storage::exists($payslipLastMonth)){
                Storage::delete($payslipLastMonth);
            }
        $payslip2ndLastMonth=$empWorkExpRecord[0]->payslip_2nd_last_month;
            if(Storage::exists($payslip2ndLastMonth)){
                Storage::delete($payslip2ndLastMonth);
            }
        $payslip3rdLastMonth=$empWorkExpRecord[0]->payslip_3rd_last_month;
            if(Storage::exists($payslip3rdLastMonth)){
                Storage::delete($payslip3rdLastMonth);
            }
            $deleteService=$this->employeeWorkExperienceService->empWorkExpDelete($decripedEWEslug);
                if($deleteService){
                $msg='Employee Work Exprience Removed Sucessfull';
                }
                else{
                $msg='Employee Work Exprience Removed Error';
                }
            $request->session()->flash('message',$msg);
            return redirect('admin/employee/manage-employee-workexp/'.Crypt::encrypt($empWorkExpRecord[0]->emloyee_slug));
        }
}
