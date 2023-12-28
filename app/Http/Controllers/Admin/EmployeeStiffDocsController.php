<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EmployeeStiffDocsService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class EmployeeStiffDocsController extends Controller
{
    protected $employeeStiffDocsService;
    public function __construct(EmployeeStiffDocsService $employeeStiffDocsService){
        $this->employeeStiffDocsService=$employeeStiffDocsService;
    }
    public function manageEmployeeStiffDocs($employeeslug = '')
    {
        $decripedEmployeeslug = Crypt::decrypt($employeeslug);
        $arr = $this->employeeStiffDocsService->findEmployeeDocsByEmpSlug($decripedEmployeeslug);

        if (count($arr) > 0) {
            $result['pf_uan_number'] = $arr[0]->pf_uan_number;
            $result['aadhar_card'] = $arr[0]->aadhar_card;
            $result['pan_card'] = $arr[0]->pan_card;
            $result['driving_licence'] = $arr[0]->driving_licence;
            $result['passport'] = $arr[0]->passport;
            $result['sslc_marks_card'] = $arr[0]->sslc_marks_card;
            $result['puc_marks_card'] = $arr[0]->puc_marks_card;
            $result['degree_marks_card'] = $arr[0]->degree_marks_card;
            $result['higher_degree_marks_card'] = $arr[0]->higher_degree_marks_card;
            $result['emp_slug'] = Crypt::encrypt($arr[0]->emp_slug);
            $result['is_update'] = 'true';
            $result['asterisk'] = '';
            $result['required'] = '';
        } else {
            $result['pf_uan_number']='';
            $result['aadhar_card'] = '';
            $result['pan_card'] = '';
            $result['driving_licence'] = '';
            $result['passport'] = '';
            $result['sslc_marks_card'] = '';
            $result['puc_marks_card'] = '';
            $result['degree_marks_card'] = '';
            $result['higher_degree_marks_card'] = '';
            $result['emp_slug'] = $employeeslug;
            $result['is_update'] = 'false';
            $result['asterisk'] = '*';
            $result['required'] = 'required';

        }
        return view('Admin.manage_employee_stiffdocs',$result);
    }
    public function manageEmployeeStiffDocsProcess(Request $request){
        $decripedEmployeeslug = Crypt::decrypt($request->emp_slug);
        $rowData = $this->employeeStiffDocsService->findEmployeeDocsByEmpSlug($decripedEmployeeslug);
        $empDocCount=count($rowData);
        if($empDocCount>0){
            $id=$rowData[0]->id;
            $empSlug=$rowData[0]->emp_slug;
            $esdSlug=$rowData[0]->esd_slug;
            if($request->has('aadhar_card')){
                $aadharCard=$rowData[0]->aadhar_card;
                if(Storage::exists($aadharCard)){
                    Storage::delete($aadharCard);
                    $aadharCard=$request->file('aadhar_card')->store('mimes/employee/stiffdocs');
                }
            }else{
                $aadharCard=$rowData[0]->aadhar_card;
            }
            if($request->has('pan_card')){
                $panCard=$rowData[0]->pan_card;
                if(Storage::exists($panCard)){
                    Storage::delete($panCard);
                    $panCard=$request->file('pan_card')->store('mimes/employee/stiffdocs');
                }
            }else{
                $panCard=$rowData[0]->pan_card;
            }
            if($request->has('driving_licence')){
                $drivingLicence=$rowData[0]->driving_licence;
                if(Storage::exists($drivingLicence)){
                    Storage::delete($drivingLicence);
                    $drivingLicence=$request->file('driving_licence')->store('mimes/employee/stiffdocs');
                }
            }else{
                $drivingLicence=$rowData[0]->driving_licence;
            }
            if($request->has('passport')){
                $passport=$rowData[0]->passport;
                if(Storage::exists($passport)){
                    Storage::delete($passport);
                    $passport=$request->file('passport')->store('mimes/employee/stiffdocs');
                }
            }else{
                $passport=$rowData[0]->passport;
            }
            if($request->has('sslc_marks_card')){
                $sslcMarksCard=$rowData[0]->sslc_marks_card;
                if(Storage::exists($sslcMarksCard)){
                    Storage::delete($sslcMarksCard);
                    $sslcMarksCard=$request->file('sslc_marks_card')->store('mimes/employee/stiffdocs');
                }
            }else{
                $sslcMarksCard=$rowData[0]->sslc_marks_card;
            }
            if($request->has('puc_marks_card')){
                $pucMarksCard=$rowData[0]->puc_marks_card;
                if(Storage::exists($pucMarksCard)){
                    Storage::delete($pucMarksCard);
                    $pucMarksCard=$request->file('puc_marks_card')->store('mimes/employee/stiffdocs');
                }
            }else{
                $pucMarksCard=$rowData[0]->puc_marks_card;
            }
            if($request->has('degree_marks_card')){
                $degreeMarksCard=$rowData[0]->degree_marks_card;
                if(Storage::exists($degreeMarksCard)){
                    Storage::delete($degreeMarksCard);
                    $degreeMarksCard=$request->file('degree_marks_card')->store('mimes/employee/stiffdocs');
                }
            }else{
                $degreeMarksCard=$rowData[0]->degree_marks_card;
            }
            if($request->has('higher_degree_marks_card')){
                $higherDegreeMarksCard=$rowData[0]->higher_degree_marks_card;
                if(Storage::exists($higherDegreeMarksCard)){
                    Storage::delete($higherDegreeMarksCard);
                    $higherDegreeMarksCard=$request->file('higher_degree_marks_card')->store('mimes/employee/stiffdocs');
                }
            }else{
                $higherDegreeMarksCard=$rowData[0]->higher_degree_marks_card;
            }
            $data=true;
        }else{
            $id=0;
            $empSlug=$decripedEmployeeslug;
            $esdSlug=Str::slug(time().rand());
            if($request->has('aadhar_card')){
                $aadharCard=$request->file('aadhar_card')->store('mimes/employee/stiffdocs');
            }else{
                $aadharCard='';
            }
            if($request->has('pan_card')){
                $panCard=$request->file('pan_card')->store('mimes/employee/stiffdocs');
            }else{
                $panCard='';
            }
            if($request->has('driving_licence')){
                $drivingLicence=$request->file('driving_licence')->store('mimes/employee/stiffdocs');
            }else{
                $drivingLicence='';
            }
            if($request->has('passport')){
                $passport=$request->file('passport')->store('mimes/employee/stiffdocs');
            }else{
                $passport='';
            }
            if($request->has('sslc_marks_card')){
                $sslcMarksCard=$request->file('sslc_marks_card')->store('mimes/employee/stiffdocs');
            }else{
                $sslcMarksCard='';
            }
            if($request->has('puc_marks_card')){
                $pucMarksCard=$request->file('puc_marks_card')->store('mimes/employee/stiffdocs');
            }else{
                $pucMarksCard='';
            }
            if($request->has('degree_marks_card')){
                $degreeMarksCard=$request->file('degree_marks_card')->store('mimes/employee/stiffdocs');
            }else{
                $degreeMarksCard='';
            }
            if($request->has('higher_degree_marks_card')){
                $higherDegreeMarksCard=$request->file('higher_degree_marks_card')->store('mimes/employee/stiffdocs');
            }else{
                $higherDegreeMarksCard='';
            }
            $data = $request->validate([
                'aadhar_card' => 'required|mimes:jpg,jpeg,png,pdf',
                'pan_card' => 'required|mimes:jpg,jpeg,png,pdf',
                'sslc_marks_card' => 'required|mimes:jpg,jpeg,png,pdf',
                'puc_marks_card' => 'required|mimes:jpg,jpeg,png,pdf',
                'degree_marks_card' => 'required|mimes:jpg,jpeg,png,pdf',
            ]);
        }
        if($data){
            $createUpdateAction=$this->employeeStiffDocsService->createOrUpdateEmployeeStiffDocs($id,$request,$esdSlug,$empSlug,
            $aadharCard,$panCard,$drivingLicence,$passport,$sslcMarksCard,$pucMarksCard,$degreeMarksCard,$higherDegreeMarksCard);
            if($createUpdateAction){
                if($empDocCount>0){
                    $msg='Employee Documents sucessfully updated';
                 }
                 else{
                    $msg='Employee Documents sucessfully inserted';
                 }
                 $request->session()->flash('message',$msg);
                 return redirect('admin/employee/manage-employee-stiffdoc/'.$request->emp_slug);
            }
        }
    }
}
