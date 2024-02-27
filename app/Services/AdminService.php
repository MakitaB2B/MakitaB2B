<?php
namespace App\Services;
use App\Models\Admin\AdminLogin;
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
    public function getAllLoginActivities(){
        return AdminLogin::with('employee:employee_no,full_name,phone_number,employee_slug')->whereNotNull('last_activity')->orderBy('last_activity','desc')->get();
    }
    public function checkIfRegisterByPhone($empPhone){
        return DB::table('employees')->where(['phone_number'=>$empPhone])->get(['employee_slug','status','phone_number','full_name']);
    }
    public function sendPasswordOTP($empSlug,$empPrimaryPhone,$empFullName){
        $otpGenerator = rand(100000,999999);
        $encryptedOTP=Crypt::encrypt($otpGenerator);
        $updateOTP=DB::table('employees')->where('employee_slug', '=', $empSlug)->
            update(['otp' => $encryptedOTP,'otp_created_at' => Carbon::now()]);
            if($updateOTP){
            $mobile=$empPrimaryPhone;
            $message="Dear $empFullName, Your Makita Login OTP: $otpGenerator is valid for 30 mins. Use it to set/reset password. Do not share.";
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
        $empInfo=DB::table('employees')->where('employee_slug',$decryptEmpSlug)->get('employee_no');

        $empNo=$empInfo[0]->employee_no;
        $password=Hash::make($password);
        $adminSlug=Str::slug(rand().rand());
        $empLoginInfo=AdminLogin::where(['employee_slug'=>$decryptEmpSlug])->get();
        if(count($empLoginInfo)>0){
            $id=$empLoginInfo[0]->id;
        }else{
            $id=0;
        }
        $operate=DB::table('admin_logins')->updateOrInsert(
            ['id' =>$id],
            ['employee_slug'=> $decryptEmpSlug,'access_id'=>$empNo,
            'password'=>$password,'status'=>1,'admin_login_slug'=>$adminSlug,
            'created_by'=>'1']
         );
         if($operate){
            $message="Dear Shankhadip, Welcome to Makita! Access with Employee ID: 4141 and your unique Password for a seamless experience.";
            Sms::sendSMS($message,$mobile);
            return true;
         }

    }
}
?>
