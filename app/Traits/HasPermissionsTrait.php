<?php
namespace App\Traits;

use App\Models\Admin\Role;
use App\Models\Admin\Permission;
use App\Models\Admin\RoleEmployee;
use App\Models\Admin\PermissionEmployees;
use App\Models\Admin\ModuleEmployee;
use Auth;


trait HasPermissionsTrait{

    // get permissions
    public function getAllPermisssions($permission){
        return Permission::whereIn('permission_slug',$permission)->get();
    }

    // check has permission
    // public function hasPermission($permission){
    //     return (bool) $this->permissions->where('permission_slug',$permission->permission_slug)->count();
    // }

    //check has role
    public function hasRole(...$roles){
        $empSlug=Auth::guard('admin')->user()->employee_slug;
        foreach($roles as $role){
            if(RoleEmployee::where('employee_slug',$empSlug)->where('role_slug',$role)->count()==1){
                return true;
            }
        }
        return false;
    }
     //check has permission
     public function hasPermission(...$permissions){
        $empSlug=Auth::guard('admin')->user()->employee_slug;
        foreach($permissions as $permission){
            if(PermissionEmployees::where('employee_slug',$empSlug)->where('permission_slug',$permission)->count()==1){
                return true;
            }
        }
        return false;
    }
    //check has Access Modules
    public function hasModuleAccess(...$modules){
        $empSlug=Auth::guard('admin')->user()->employee_slug;
        foreach($modules as $module){
            if(ModuleEmployee::where('employee_slug',$empSlug)->where('module_slug',$module)->count()==1){
                return true;
            }
        }
        return false;
    }
    public function hasPermissionTo($permission){
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    public function hasPermissionThroughRole($permission){
        foreach($permission->roles as $role){
            if($this->roles->contains($role)){
                return true;
            }
        }
        return false;
    }

    //give permission
    public function givePermissionTo(...$permissions){
        $permissions=$this->getAllPermisssions($permissions);
        if($permissions == null){
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'permission_employees','employee_slug','permission_slug');
    }
    public function roles(){
        return $this->belongsToMany(Role::class,'role_employees');
    }


}
