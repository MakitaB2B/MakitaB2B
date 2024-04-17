<?php
namespace App\Services;
use App\Models\Admin\Role;
use App\Models\Admin\Permission;
use App\Models\Admin\AccessModule;
use Illuminate\Support\Facades\DB;
class RolePermissionService{
    public function getAllRole(){
        return Role::latest()->get();
    }
    public function findRoleBySlug($slug){
        return Role::where(['role_slug'=>$slug])->get();
    }
    public function createOrUpdateRole($id,$request,$roleSlug,$dataOparateEmpSlug){
        $operate=Role::updateOrCreate(
            ['id' =>$id],
            ['name'=>$request->name,'role_slug'=>$roleSlug,'status'=>$request->status,'created_by'=>$dataOparateEmpSlug]
         );
         if($operate){
            return true;
         }
    }
    public function getAllPermissions(){
        return Permission::latest()->get();
    }
    public function findPermissionBySlug($slug){
        return Permission::where(['permission_slug'=>$slug])->get();
    }
    public function createOrUpdatePermission($id,$request,$permissionSlug,$dataOparateEmpSlug){
        $operate=Permission::updateOrCreate(
            ['id' =>$id],
            ['name'=>$request->name,'permission_slug'=>$permissionSlug,'status'=>$request->status,'created_by'=>$dataOparateEmpSlug]
         );
         if($operate){
            return true;
         }
    }
    public function getAllAccessModules(){
        return AccessModule::latest()->get();
    }
    public function findAccessModuleBySlug($slug){
        return AccessModule::where(['module_slug'=>$slug])->get();
    }
    public function createOrUpdateAccessModule($id,$request,$accessModuleSlug,$dataOparateEmpSlug){
        $operate=AccessModule::updateOrCreate(
            ['id' =>$id],
            ['name'=>$request->name,'module_slug'=>$accessModuleSlug,'status'=>$request->status,'created_by'=>$dataOparateEmpSlug]
         );
         if($operate){
            return true;
         }
    }

}
?>
