<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Admin\Sms;
use Auth;

class AdminLoginController extends Controller
{
    protected $adminService;
    public function __construct(AdminService $adminService){
        $this->adminService=$adminService;
    }
    public function index(){
        if(Auth::guard('admin')->check()){
            $status=Auth::guard('admin')->user()->status;
            if($status==0){
                    return view('Admin.login');
            }else{
                return redirect()->route('admin.dashboard')->with('msg','You are alredy Logged IN');
            }
        }else{
            return view('Admin.login');
        }
    }
    public function auth(Request $request){
        $userId = $request->post('userid');
        $password =$request->post('password');
        if(Auth::guard('admin')->attempt(['access_id'=>$userId, 'password'=>$password])){
            $status=Auth::guard('admin')->user()->status;
            $hasPasswordSet=Auth::guard('admin')->user()->password_set;
            if($status==0){
                return back()->with('error','Access has been revoked!');
            }elseif($hasPasswordSet==0){
                return redirect('admin/register');
            }else{
                return redirect()->route('admin.dashboard')->with('msg','You are successfully logged in');
            }
        }else{
            return back()->with('error','Invalid Email or Password');
        }
    }
    public function dashboard(Request $request){
        $empAuth=Auth::guard('admin')->user();
        $dashboardData['empLoginActivity']=$this->adminService->getAllLoginActivities();
        return view('Admin/dashboard',$dashboardData);
    }
    public function adminList(){
        $adminList=$this->adminService->getAllAdminWithEmpDtls();
        return view('Admin.admins',compact('adminList'));
    }
    public function manageAdmin($adminSlug = '')
    {
        if ($adminSlug > 0) {
            $decripedAdminSlug = Crypt::decrypt($adminSlug);
            $arr = $this->adminService->findAdminBySlug($decripedAdminSlug);
            $result['employee_slug'] = $arr[0]->employee_slug;
            $result['access_id'] = $arr[0]->access_id;
            $result['status'] = $arr[0]->status;
            $result['admin_login_slug'] = Crypt::encrypt($arr[0]->admin_login_slug);
            $result['admin_login_id'] = Crypt::encrypt($arr[0]->id);
            $result['employee_roles'] = $this->adminService->getAllRolesSpecificEmployee($arr[0]->employee_slug);
            $result['employee_permision'] = $this->adminService->getAllPermissionSpecificEmployee($arr[0]->employee_slug);
            $result['employee_access_modules'] = $this->adminService->getAllModuleAccessSpecificEmployee($arr[0]->employee_slug);
        } else {
            $result['employee_slug'] = '';
            $result['access_id'] = '';
            $result['status'] = '';
            $result['admin_login_slug'] = Crypt::encrypt(0);
            $result['admin_login_id'] = Crypt::encrypt(0);
            $result['employee_roles'] = [];
            $result['employee_permision'] = [];
            $result['employee_access_modules'] = [];
        }
        $result['roles'] =$this->adminService->getAllRoles();
        $result['permissions'] =$this->adminService->getAllPermissions();
        $result['accessmodules'] =$this->adminService->getAllAccessModules();
        $result['allemp']=$this->adminService->findActiveEmployee();
        return view('Admin.manage_admin', $result);
    }
    public function manageAdminProcess(Request $request){
        $decripedSlug = Crypt::decrypt($request->admin_login_slug);
        $id=Crypt::decrypt($request->admin_login_id);
        if($decripedSlug>0){
            $rowData=$this->adminService->findAdminBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $adminSlug=$rowData[0]->admin_login_slug;
        }else{
            $id=0;
            $adminSlug=Str::slug($decripedSlug.rand());
        }
        $data = $request->validate([
            'employee_slug' => 'required|unique:admin_logins,employee_slug,'.$id,
            'access_id' => 'required|unique:admin_logins,access_id,'.$id,
            'status' => 'required|numeric',
            'roles'=>'required|array',
            'accessmodules'=>'required|array',
        ]);
        if($data){
            $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug ;
            $password=Hash::make($request->access_id);
            $empSlug=Crypt::decrypt($request->employee_slug);
            $createUpdateAction=$this->adminService->createOrUpdateAdmin($id,$password,$request,$adminSlug,$dataOparateEmpSlug,$empSlug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Admin sucessfully updated';
                 }
                 else{
                    $empData=$this->adminService->findEmployeeBySlug($empSlug);
                    $empMobile=$empData[0]->phone_number;
                    $empID=$empData[0]->employee_no;
                    $empName=$empData[0]->full_name;
                    $message="Dear $empName, Welcome to Makita Power Tools India!, Congratulations! Your Makita login entity has been generated & your user ID is $empID, please register by visiting https://makita.ind.in/admin/register, for any query you can reach  our IT support, Best Regards, Makita Power Tools India";
                    Sms::sendSMS($message,$empMobile);
                    $msg='Admin sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/admins');
            }
         }
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('adminlogin')->with('error','You are logged out');
    }
    public function register(){
        return view('Admin.register');
    }
    public function checkRegisterByPhone(Request $request){
        $checker=$this->adminService->checkIfRegisterByPhone($request->empprimphone);
        if( count($checker)>0){
            $status=$checker[0]->status;
            if($status != 1){
                $msg='Access Revoked, Contact Admin';
                $request->session()->flash('message',$msg);
                return redirect('admin/register');
            }else{
                $empSlug=$checker[0]->employee_slug;
                $empPrimaryPhone=$checker[0]->phone_number;
                $empFullName=$checker[0]->full_name;
                $OtpChecker=$this->adminService->sendPasswordOTP($empSlug,$empPrimaryPhone,$empFullName);
                if($OtpChecker==1){
                    $encEmpSlug=Crypt::encrypt($empSlug);
                    return redirect('admin/checkotp/'.$encEmpSlug);
                }else{
                    $msg='Error! Try Again';
                    $request->session()->flash('message',$msg);
                    return redirect('admin/register');
                }
            }
        }else{
            $msg='Pone number not registered';
            $request->session()->flash('message',$msg);
            return redirect('admin/register');
        }
    }
    public function verifyEmpPwrdOtpControler(Request $request){
        $otp=$request->otp;
        $empSlug=$request->empslug;
        $otpChecker=$this->adminService->verifyEmpLoginRegisOTP($otp,$empSlug);
        if($otpChecker==1){
            $encEmpslug=$empSlug;
            return redirect('admin/empresetpassword/'.$encEmpslug);
        }else{
            $msg=$otpChecker;
            $request->session()->flash('message',$msg);
            return redirect('admin/checkotp/'.$empSlug);
        }
    }
    public function empResetCreatePassword(Request $request){
        $data = $request->validate([
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ]);
        $password=$request->password;
        $decryptEmpSlug=Crypt::decrypt($request->empslug);
        $createupdtPass=$this->adminService->empCreateUpdatePasswordService($password,$decryptEmpSlug);
        if($createupdtPass){
            $msg='Congrats! Login with Employee ID & Password';
            $request->session()->flash('error',$msg);
            return redirect('admin/login');
        }else{
            echo "Fail";
        }
    }
    public function otpView($empSlug){
        return view('Admin.forgetpass_otp',compact('empSlug'));
    }
    public function resetPasswordView($empSlug){
        return view('Admin.reset_password',compact('empSlug'));
    }
}
