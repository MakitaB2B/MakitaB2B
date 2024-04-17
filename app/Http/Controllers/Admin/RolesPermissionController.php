<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RolePermissionService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Auth;
class RolesPermissionController extends Controller
{
    protected $rolePermissionService;
    public function __construct(RolePermissionService $rolePermissionService){
        $this->rolePermissionService=$rolePermissionService;
    }
    public function roleIndex(){
        $roleList=$this->rolePermissionService->getAllRole();
        return view('Admin.roles',compact('roleList'));
    }
    public function manageRole($roleslug = '')
    {
        if ($roleslug > 0) {
            $decripedRolelug = Crypt::decrypt($roleslug);
            $arr = $this->rolePermissionService->findRoleBySlug($decripedRolelug);
            $result['name'] = $arr[0]->name;
            $result['status'] = $arr[0]->status;
            $result['role_slug'] = Crypt::encrypt($arr[0]->role_slug);
        } else {
            $result['name'] = '';
            $result['status'] = '';
            $result['role_slug'] = Crypt::encrypt(0);
        }
        return view('Admin.manage_role', $result);
    }
    public function manageRoleProcess(Request $request){

        $decripedSlug = Crypt::decrypt($request->role_slug);
        if($decripedSlug>0){
            $rowData=$this->rolePermissionService->findRoleBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $roleSlug=$rowData[0]->role_slug;
        }else{
            $id=0;
            $roleSlug=Str::slug(rand().rand());
        }
        $data = $request->validate([
            'name' => 'required|min:2|max:250|unique:roles,name,'.$id,
        ]);
        if($data){
            $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug;
            $createUpdateAction=$this->rolePermissionService->createOrUpdateRole($id,$request,$roleSlug,$dataOparateEmpSlug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Role sucessfully updated';
                 }
                 else{
                    $msg='Role sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/roles');
            }
         }
    }
    public function permissionIndex(){
        $permissionList=$this->rolePermissionService->getAllPermissions();
        return view('Admin.permission',compact('permissionList'));
    }
    public function managePermission($permissionslug = '')
    {
        if ($permissionslug > 0) {
            $decripedRolelug = Crypt::decrypt($permissionslug);
            $arr = $this->rolePermissionService->findPermissionBySlug($decripedRolelug);
            $result['name'] = $arr[0]->name;
            $result['status'] = $arr[0]->status;
            $result['permission_slug'] = Crypt::encrypt($arr[0]->permission_slug);
        } else {
            $result['name'] = '';
            $result['status'] = '';
            $result['permission_slug'] = Crypt::encrypt(0);
        }
        return view('Admin.manage_permission', $result);
    }
    public function managePermissionProcess(Request $request){

        $decripedSlug = Crypt::decrypt($request->permission_slug);
        if($decripedSlug>0){
            $rowData=$this->rolePermissionService->findPermissionBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $permissionSlug=$rowData[0]->permission_slug;
        }else{
            $id=0;
            $permissionSlug=Str::slug(rand().rand());
        }
        $data = $request->validate([
            'name' => 'required|min:2|max:250|unique:permissions,name,'.$id,
        ]);
        if($data){
            $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug;
            $createUpdateAction=$this->rolePermissionService->createOrUpdatePermission($id,$request,$permissionSlug,$dataOparateEmpSlug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Permission sucessfully updated';
                 }
                 else{
                    $msg='Permission sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/permission');
            }
         }
    }
    public function accessModuleIndex(){
        $accessModuleList=$this->rolePermissionService->getAllAccessModules();
        return view('Admin.access_module',compact('accessModuleList'));
    }
    public function manageAccessModule($moduleslug = '')
    {
        if ($moduleslug > 0) {
            $decripedRolelug = Crypt::decrypt($moduleslug);
            $arr = $this->rolePermissionService->findAccessModuleBySlug($decripedRolelug);
            $result['name'] = $arr[0]->name;
            $result['status'] = $arr[0]->status;
            $result['module_slug'] = Crypt::encrypt($arr[0]->module_slug);
        } else {
            $result['name'] = '';
            $result['status'] = '';
            $result['module_slug'] = Crypt::encrypt(0);
        }
        return view('Admin.manage_access_module', $result);
    }
    public function manageAccessModuleProcess(Request $request){

        $decripedSlug = Crypt::decrypt($request->access_module_slug);
        if($decripedSlug>0){
            $rowData=$this->rolePermissionService->findAccessModuleBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $accessModuleSlug=$rowData[0]->module_slug;
        }else{
            $id=0;
            $accessModuleSlug=Str::slug(rand().rand());
        }
        $data = $request->validate([
            'name' => 'required|min:2|max:250|unique:access_modules,name,'.$id,
        ]);
        if($data){
            $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug;
            $createUpdateAction=$this->rolePermissionService->createOrUpdateAccessModule($id,$request,$accessModuleSlug,$dataOparateEmpSlug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Access Module sucessfully updated';
                 }
                 else{
                    $msg='Access Module sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/access-modules');
            }
         }
    }
}
