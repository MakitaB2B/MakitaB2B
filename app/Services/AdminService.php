<?php
namespace App\Services;
use App\Models\Admin\AdminLogin;
use App\Models\Admin\Role;
use App\Models\Admin\RoleEmployee;
use App\Models\Admin\PermissionEmployees;
use App\Models\Admin\Permission;
use App\Models\Admin\AccessModule;
use App\Models\Admin\ModuleEmployee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Models\Admin\Sms;
use Carbon\Carbon;

class AdminService{
    public function getAllAdmins(){
        return AdminLogin::orderBy('id','desc')->get();
    }
    public function getAllAdminWithEmpDtls(){
        return AdminLogin::with('employee')->with('employeeRoles')->with('employeePermission')->with('employeeAccessModules')->orderBy('id','desc')->get();
    }
    public function findAdminBySlug($adminSlug){
        return AdminLogin::where(['admin_login_slug'=>$adminSlug])->get();
    }
    public function findAdminLoginByEmpSlugAccessID($empSlug,$accessId){
        return AdminLogin::where(['employee_slug'=>$empSlug])->where(['access_id'=>$accessId])->get();
    }
    public function findActiveEmployee(){
        return DB::table('employees')->where(['status'=>1])->orderBy('id','desc')->get(['employee_no','full_name','employee_slug']);
    }
    public function findEmployeeBySlug($empSlug){
        return DB::table('employees')->where(['employee_slug'=>$empSlug])->get(['employee_no','full_name','phone_number']);
    }
    public function createOrUpdateAdmin($id,$password,$request,$adminSlug,$dataOparateEmpSlug,$empSlug){

        $operate=AdminLogin::updateOrCreate(
            ['id' =>$id],
            ['employee_slug'=> $empSlug,'access_id'=>$request->access_id,
            'password'=>$password,'status'=>$request->status,'admin_login_slug'=>$adminSlug,
            'created_by'=>$dataOparateEmpSlug]
         );

        // Roles
        $updateRole=$request->input('roles');
        if($id>0){
            $empRoleBM=$request->input('emproles_befor_modify');
                if($empRoleBM != $updateRole){
                $roleArrayDiffToDelete=array_diff($empRoleBM,$updateRole);
                $roleArrayDiffToInsert=array_diff($updateRole,$empRoleBM);

                if(count($roleArrayDiffToInsert)>0){
                    foreach ($roleArrayDiffToInsert as $roleData) {
                        $roleRecords[] = [
                            'employee_slug' => $empSlug,
                            'role_slug' => $roleData,
                            'created_by' => $dataOparateEmpSlug,
                        ];
                    }
                    RoleEmployee::insert($roleRecords);
                }
                if(count($roleArrayDiffToDelete)>0){
                    foreach($roleArrayDiffToDelete as $roleSlugDel){
                    RoleEmployee::WHERE('role_slug', $roleSlugDel)->WHERE('employee_slug', $empSlug)->first()->delete();
                    }
                }
            }
        }if($id == 0){
            foreach ($updateRole as $roleData) {
                $roleRecordsInsert[] = [
                    'employee_slug' => $empSlug,
                    'role_slug' => $roleData,
                    'created_by' => $dataOparateEmpSlug,
                ];
            }
            RoleEmployee::insert($roleRecordsInsert);
        }

        // Permissions
        $updatePermission=$request->input('permissions');
        if($id>0){
        $empPermissionBM=$request->input('emppermission_befor_modify');
        if($empPermissionBM != $updatePermission){
                $permissionArrayDiffToDelete=array_diff($empPermissionBM,$updatePermission);
                $permissionArrayDiffToInsert=array_diff($updatePermission,$empPermissionBM);

                if(count($permissionArrayDiffToInsert)>0){
                    foreach ($permissionArrayDiffToInsert as $permissionData) {
                        $permissionRecords[] = [
                            'employee_slug' => $empSlug,
                            'permission_slug' => $permissionData,
                            'created_by' => $dataOparateEmpSlug,
                        ];
                    }
                    PermissionEmployees::insert($permissionRecords);
                }
                if(count($permissionArrayDiffToDelete)>0){
                    foreach($permissionArrayDiffToDelete as $permissionSlugDel){
                        PermissionEmployees::WHERE('permission_slug', $permissionSlugDel)->WHERE('employee_slug', $empSlug)->first()->delete();
                    }
                }
            }
        }if($id == 0){
            foreach ($updatePermission as $permissionData) {
                $permissionRecordsInsert[] = [
                    'employee_slug' => $empSlug,
                    'permission_slug' => $permissionData,
                    'created_by' => $dataOparateEmpSlug,
                ];
            }
            PermissionEmployees::insert($permissionRecordsInsert);
        }

        // Access Modules
        $updateAccessModule=$request->input('accessmodules');
        if($id>0){
        $empAccessModulesBM=$request->input('accessmodules_befor_modify');
        if($empAccessModulesBM != $updateAccessModule){
            $accessModulesArrayDiffToDelete=array_diff($empAccessModulesBM,$updateAccessModule);
            $accessModulesArrayDiffToInsert=array_diff($updateAccessModule,$empAccessModulesBM);

            if(count($accessModulesArrayDiffToInsert)>0){
                foreach ($accessModulesArrayDiffToInsert as $accessModuleList) {
                   $moduleRecords[] = [
                        'employee_slug' => $empSlug,
                        'module_slug' => $accessModuleList,
                        'created_by' => $dataOparateEmpSlug,
                    ];
                }
                ModuleEmployee::insert($moduleRecords);
            }
            if(count($accessModulesArrayDiffToDelete)>0){
                foreach($accessModulesArrayDiffToDelete as $moduleSlugDel){
                    ModuleEmployee::WHERE('module_slug', $moduleSlugDel)->WHERE('employee_slug', $empSlug)->first()->delete();
                }
            }
        }
        }if($id == 0){
            foreach ($updateAccessModule as $accessModuleList) {
                $moduleRecordsInsert[] = [
                     'employee_slug' => $empSlug,
                     'module_slug' => $accessModuleList,
                     'created_by' => $dataOparateEmpSlug,
                 ];
             }
             ModuleEmployee::insert($moduleRecordsInsert);
        }

        if($operate){
            return true;
        }
    }
    public function getAllLoginActivities(){
        return AdminLogin::with('employee:employee_no,full_name,phone_number,employee_slug')->whereNotNull('last_activity')->orderBy('last_activity','desc')->get();
    }
    public function checkIfRegisterByPhone($empPhone){
        return DB::table('employees')->where(['phone_number'=>$empPhone])->where(['status'=>1])->get(['employee_slug','status','phone_number','full_name','employee_no']);
    }
    public function sendPasswordOTP($empSlug,$empPrimaryPhone,$empFullName){
        $otpGenerator = rand(100000,999999);
        $encryptedOTP=Crypt::encrypt($otpGenerator);
        $updateOTP=DB::table('employees')->where('employee_slug', '=', $empSlug)->
            update(['otp' => $encryptedOTP,'otp_created_at' => Carbon::now()]);
            if($updateOTP){
            $mobile=$empPrimaryPhone;
            $message="Dear $empFullName, Your Makita Login OTP: $otpGenerator is valid for 30 mins. Use it to set/reset password. Do not share. Best,Makita Power Tools India";
            Sms::sendSMS($message,$mobile);
            return 1;
            }else{
                return 0;
            }
    }
    public function verifyEmpLoginRegisOTP($otp,$empSlug){
        $decryptEmpSlug=Crypt::decrypt($empSlug);
        $checkOTP = DB::table('employees')->where('employee_slug',$decryptEmpSlug)->first();
        if($checkOTP){
            if(Crypt::decrypt($checkOTP->otp) == $otp){
                $otpCreatedAt = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $checkOTP->otp_created_at);
                $currentTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
                $otpMinutesDiff = $otpCreatedAt->diffInMinutes($currentTime);
                if($otpMinutesDiff<=30){
                    return 1;
                }else{
                    return "30 minutes excede,this OTP expired";
                }
            }else{
                return "Entered OTP is Wrong";
            }
        }else{
            return "Employee not found";
        }
    }
    public function empCreateUpdatePasswordService($password,$decryptEmpSlug){
        $empInfo=DB::table('employees')->where('employee_slug',$decryptEmpSlug)->get(['employee_no','full_name','phone_number']);
        $empNo=$empInfo[0]->employee_no;
        $empName=$empInfo[0]->full_name;
        $mobile=$empInfo[0]->phone_number;
        $password=Hash::make($password);
        $adminSlug=Str::slug(rand().rand());
        $empLoginInfo=AdminLogin::where(['employee_slug'=>$decryptEmpSlug])->get();
        if(count($empLoginInfo)>0){
            $id=$empLoginInfo[0]->id;
            $setPassword=1;
        }else{
            $id=0;
            $setPassword=0;
        }
        $operate=DB::table('admin_logins')->updateOrInsert(
            ['id' =>$id],
            ['employee_slug'=> $decryptEmpSlug,'access_id'=>$empNo,
            'password'=>$password,'status'=>1,'password_set'=>$setPassword,'admin_login_slug'=>$adminSlug,
            'created_by'=>'1']
         );
         if($operate){
            $message="Dear $empName, Welcome to Makita! Access with Employee ID: $empNo and your unique Password for a seamless experience. Best,Makita Power Tools India ";
            Sms::sendSMS($message,$mobile);
            return true;
         }
    }
    public function getAllRoles(){
        return Role::get();
    }
    public function getAllPermissions(){
        return Permission::get();
    }
    public function getAllAccessModules(){
        return AccessModule::get();
    }
    public function getAllRolesSpecificEmployee($empSlug){
        return RoleEmployee::WHERE(['employee_slug'=>$empSlug])->get();
    }
    public function getAllPermissionSpecificEmployee($empSlug){
        return PermissionEmployees::WHERE(['employee_slug'=>$empSlug])->get();
    }
    public function getAllModuleAccessSpecificEmployee($empSlug){
        return ModuleEmployee::WHERE(['employee_slug'=>$empSlug])->get();
    }
}
?>
