<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DepartmentService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    protected $departmentService;
    public function __construct(DepartmentService $departmentService){
        $this->departmentService=$departmentService;
    }
    public function index(){
        $departmentList=$this->departmentService->getAllDepartments();
        return view('Admin.departments',compact('departmentList'));
    }
    public function manageDepartment($departmentslug = '')
    {
        if ($departmentslug > 0) {
            $decripedDepartmentSlug = Crypt::decrypt($departmentslug);
            $arr = $this->departmentService->findDepartmentBySlug($decripedDepartmentSlug);
            $result['name'] = $arr[0]->name;
            $result['status'] = $arr[0]->status;
            $result['department_slug'] = Crypt::encrypt($arr[0]->department_slug);
        } else {
            $result['name'] = '';
            $result['status'] = '';
            $result['department_slug'] = Crypt::encrypt(0);
        }
        return view('Admin.manage_departments', $result);
    }
    public function manageDepartmentProcess(Request $request){
        $decripedSlug = Crypt::decrypt($request->department_slug);
        if($decripedSlug>0){
            $rowData=$this->departmentService->findDepartmentBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $slug=$rowData[0]->department_slug;
        }else{
            $id=0;
            $slug=Str::slug($request->name.rand());
        }
        $data = $request->validate([
            'name' => 'required|min:2|max:250',
            'status' => 'required|numeric',
        ]);
        if($data){
            $createUpdateAction=$this->departmentService->createOrUpdateDepartment($id,$request,$slug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Department sucessfully updated';
                 }
                 else{
                    $msg='Department sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/department');
            }
         }
    }
}
