<?php
namespace App\Services;
use App\Models\Admin\AdminLogin;
use Illuminate\Support\Facades\DB;

class AdminService{
    public function getAllAdmins(){
        return AdminLogin::orderBy('id','desc')->get();
    }
    public function getAllAdminWithEmpDtls(){
        return AdminLogin::with('employee')->orderBy('id','desc')->get();
    }
    public function findAdminBySlug($adminSlug){
        return AdminLogin::where(['admin_login_slug'=>$adminSlug])->get();
    }
    public function findActiveEmployee(){
        return DB::table('employees')->where(['status'=>1])->orderBy('id','desc')->get(['employee_no','full_name','employee_slug']);
    }
    public function createOrUpdateAdmin($id,$password,$request,$adminSlug,$dataOparateEmpSlug,$empSlug){
        $operate=AdminLogin::updateOrCreate(
            ['id' =>$id],
            ['employee_slug'=> $empSlug,'access_id'=>$request->access_id,
            'password'=>$password,'status'=>$request->status,'admin_login_slug'=>$adminSlug,
            'created_by'=>$dataOparateEmpSlug]
         );
         if($operate){
            return true;
         }
    }
}
?>
