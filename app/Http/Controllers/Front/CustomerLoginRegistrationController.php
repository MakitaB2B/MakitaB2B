<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Front\Customer;
use App\Models\Front\CustomerLogin;
use App\Models\Admin\City;
use App\Models\Admin\Sms;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;

class CustomerLoginRegistrationController extends Controller
{
    public function customerSignup($cxSlug='',$flag=''){
        if($cxSlug!=''){
            $decryptedCXSlug=Crypt::decrypt($cxSlug);
        }else{
            $decryptedCXSlug=0;
        }
        if ($decryptedCXSlug > 0) {
            $cxDetails=Customer::where('customer_slug',Crypt::decrypt($cxSlug))->get(['phone','customer_slug']);
            $result['mobile_number']=$cxDetails[0]->phone;
            $result['cxslug'] = $cxDetails[0]->customer_slug;
            $result['forgetpassword'] = $flag;
        } else {
            $result['mobile_number'] = '';
            $result['cxslug'] = '';
            $result['forgetpassword'] = $flag;
        }
        return view('Front.customer_signup',$result);
    }
    public function customerSignupSigninOTPSend(Request $request){
        $data = $request->validate([
            'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10|starts_with: 6,7,8,9',
        ]);
        $cxSlug=Crypt::decrypt($request->cxslug);
        if($request->filled('forgetpassword')){
            $decryptForgetPassword=Crypt::decrypt($request->forgetpassword);
            if($decryptForgetPassword==1){
                $checkPhone = Customer::where('phone', '=', $request->mobile_number)->first();
                if ($checkPhone) {
                    $otpGenerator = rand(100000,999999);
                $encryptedOTP=Crypt::encrypt($otpGenerator);
                $updatePhoneNum= Customer::where('customer_slug', '=', $checkPhone->customer_slug)->
                update(['phone'=>$request->mobile_number,'otp' => $encryptedOTP,'otp_created_at' => Carbon::now()]);
                if($updatePhoneNum){
                    $mobile=$request->mobile_number;
                    $message="Dear user, $otpGenerator is OTP for the Makita website reset password, will valid for 30 minutes, do not share OTP with anyone. - Makita Power Tools India Pvt. Ltd.";
                    Sms::sendSMS($message,$mobile);
                    return redirect('cx-signup-otp-page/'.Crypt::encrypt($checkPhone->customer_slug).'/'.Crypt::encrypt(1));
                }
                }else{
                $msg='This Phone Number is Not Registered With Us';
                $request->session()->flash('message',$msg);
                return redirect('/cx-signup');
                }
            }
        }elseif($cxSlug>0){
            if(Customer::where('phone', '=', $request->mobile_number)->where('customer_slug', '!=', $cxSlug)->exists()){
                $msg='This Phone Number is alredy registered if it`s belongs you can proceed else please try with another number ';
                $request->session()->flash('message',$msg);
                return redirect('/cx-signup');
            }
            else{
                $otpGenerator = rand(100000,999999);
                $encryptedOTP=Crypt::encrypt($otpGenerator);
                $updatePhoneNum= Customer::where('customer_slug', '=', $cxSlug)->
                update(['phone'=>$request->mobile_number,'otp' => $encryptedOTP,'otp_created_at' => Carbon::now()]);
                if($updatePhoneNum){
                    $mobile=$request->mobile_number;
                    $message="Dear user, $otpGenerator is OTP for Makita website login, do not share OTP with anyone. -Makita Power Tools India Pvt. Ltd.";
                    Sms::sendSMS($message,$mobile);
                    return redirect('cx-signup-otp-page/'.Crypt::encrypt($cxSlug));
                }
            }
        }else{
            $checkPhone = Customer::where('phone', '=', $request->mobile_number)->first();
            if ($checkPhone) {
                $msg='This Phone Number is alredy registered please login';
                $request->session()->flash('message',$msg);
                return redirect('/cx-signup');
                // $otpGenerator = rand(1000,9999);
                // $encryptedOTP=Crypt::encrypt($otpGenerator);
                // $customerSlug=$checkPhone->customer_slug;
                // $updateOTP=Customer::where('customer_slug', '=', $customerSlug)->
                // update(['otp' => $encryptedOTP,'otp_created_at' => Carbon::now()]);
                // if($updateOTP){
                //     $mobile=$checkPhone->phone;
                //     $message="Dear user, $otpGenerator is OTP for Makita website login, do not share OTP with anyone. -Makita Power Tools India Pvt. Ltd.";
                //     Sms::sendSMS($message,$mobile);
                //     return redirect('cx-signup-otp-page/'.Crypt::encrypt($customerSlug));
                // }

             }else{
                $otpGenerator = rand(100000,999999);
                $model=new Customer();
                $model->customer_slug=Str::slug($request->mobile_number.rand().rand());
                $model->phone=$request->mobile_number;
                $model->otp=Crypt::encrypt($otpGenerator);
                $model->otp_created_at= Carbon::now();
                $model->save();
                if($model->save()){
                    $mobile=$model->phone;
                    $message="Dear user, $otpGenerator is OTP for Makita website login, do not share OTP with anyone. -Makita Power Tools India Pvt. Ltd.";
                    Sms::sendSMS($message,$mobile);
                    $cxSlug=$model->customer_slug;
                    return redirect('cx-signup-otp-page/'.Crypt::encrypt($cxSlug));
                }else{
                    echo "Did not save";
                }
            }
        }
    }
    public function customerOTPPage($cxSlug='',$flag=''){
        $cxDetails=Customer::where('customer_slug',Crypt::decrypt($cxSlug))->get();
        $result['mobile_number']=$cxDetails[0]->phone;
        $result['cxSlug']=Crypt::encrypt($cxDetails[0]->customer_slug);
        $result['flag']=$flag;
        // $result['otp']=$cxDetails[0]->otp; //To display OTP in front end
        return view('Front.customer_signin_signup_otp',$result);
    }
    public function customerSignupSigninResendOTP(Request $request){
        $decryptedCXSlug = Crypt::decrypt($request->cxslug);
        $checkCustomer = Customer::where('customer_slug',$decryptedCXSlug)->first();
        if ($checkCustomer) {
            $otpGenerator = rand(100000,999999);
            $encryptedOTP=Crypt::encrypt($otpGenerator);
            $updateOTP=Customer::where('customer_slug', '=', $decryptedCXSlug)->
            update(['otp' => $encryptedOTP,'otp_created_at' => Carbon::now()]);
            if($updateOTP){
            $mobile=$checkCustomer->phone;
            $message="Dear user, $otpGenerator is OTP for Makita website login, do not share OTP with anyone. -Makita Power Tools India Pvt. Ltd.";
            Sms::sendSMS($message,$mobile);
            return 'success';
            }else{
                return "failed";
            }
         }else{
            return "failed";
         }
    }
    public function verifyCXLoginRegisOTP(Request $request){
        $otp=$request->otp;
        $decryptCXSlug=Crypt::decrypt($request->cxslug);
        $checkOTP = Customer::where('customer_slug',$decryptCXSlug)->first();
        if($checkOTP){
            if(Crypt::decrypt($checkOTP->otp) == $otp){
                $otpCreatedAt = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $checkOTP->otp_created_at);
                $currentTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
                $otpMinutesDiff = $otpCreatedAt->diffInMinutes($currentTime);
                if($otpMinutesDiff<=30){
                    return "success";
                }else{
                    return "failed";
                }
            }else{
                return "failed";
            }
        }else{
            return "failed";
        }
    }

    public function customerSignupPersonalDetails(){
        $cxslug=Auth::guard('customer')->user()->customer_slug;
        $customerData = Customer::where('customer_slug',$cxslug)->first();
        if($customerData){
            $result['name'] = $customerData->name;
            $result['email'] = $customerData->email;
            $result['state_id'] = $customerData->state;
            $result['city_id'] = $customerData->city;
            $result['address'] = $customerData->address;
            if($customerData->state!=NULL){
                $result['cityByState']=City::where('state_id',$customerData->state)->get(['id','name']);
            }
        }else{
            $result['name'] = '';
            $result['email'] = '';
            $result['state_id'] = '';
            $result['city_id'] = '';
            $result['address'] = '';
        }

        $result['states']=DB::table('states')->where('status','1')->get(['id','name']);
        return view('Front.customer_signup_details',$result);
    }
    public function manageCustomerProfileProcess(Request $request){
        $data = $request->validate([
            'name' => 'required|min:2|max:250',
            'state' => 'required|numeric',
        ]);
        if($data){
            $cxslug=Auth::guard('customer')->user()->customer_slug;
            $model = Customer::where('customer_slug',$cxslug)->first();
            $model->name = $request->name;
            $model->email = $request->email;
            $model->state = $request->state;
            $model->city = $request->city;
            $model->address = $request->address;
            if($model->save()){
                $cxSlug=$model->customer_slug;
                return redirect('cx-warranty-registration-fairmsg/');
            }else{
                return redirect('/cx-signup-details');
            }
        }else{
            $msg='Oops! Went Wrong';
            $request->session()->flash('message',$msg);
            return redirect('/cx-signup-details');
        }
    }
    public function prepCitiesByStates(Request $request){
        $stateID=$request->stateID;
        $stateData=DB::table('cities')->where('state_id',$stateID)->get(['id','name']);
        $html='<option value="">Select State</option>';
        foreach($stateData as $list){
            $html.='<option value="'.$list->id.'">'.$list->name.'</option>';
        }
        echo $html;
    }
    public function createCXLoginPasswordView($cxslug='',$flag=''){
        $result['cxslug']=$cxslug;
        $result['flag']=$flag;
        return view('Front.customer_login_password_making',$result);
    }
    public function createCXLoginPassword(Request $request){
        $data = $request->validate([
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ]);
        $decryptCXSlug= Crypt::decrypt($request->cxslug);
        $cxInfo=Customer::where('customer_slug',$decryptCXSlug)->first();
        $model=new CustomerLogin();
        $model->customer_slug=$decryptCXSlug;
        $model->access_id=$cxInfo->phone;
        $model->password=Hash::make($request->password);
        $model->status=1;
        $model->customer_login_slug=Str::slug($request->mobile_number.rand().rand());
        if($model->save()){
            return redirect()->route('cxlogin')->with('message','You can login now! Use Phone number as in user ID');
        }
    }
    public function cxLoginView(){
        return view('Front.customer_login');
    }
    public function cxLoginProcess(Request $request){
        $userId = $request->post('user_id');
        $password =$request->post('password');
        if(Auth::guard('customer')->attempt(['access_id'=>$userId, 'password'=>$password])){
            $status=Auth::guard('customer')->user()->status;
            if($status==0){
                return back()->with('error','Access has been revoked!');
            }else{
                return redirect()->route('warranty-registration-list-spec-cx')->with('msg','You are successfully logged in');
            }
        }else{
            return back()->with('error','Invalid Email or Password');
        }
    }
    public function logout(){
        Auth::guard('customer')->logout();
        return redirect()->route('cxlogin')->with('error','You are logged out!');
    }
    public function cxForgetPasswordView(){
        echo "Hello";
    }
    public function resetCXLoginPassword(Request $request){
        $data = $request->validate([
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ]);
        $decryptCXSlug=Crypt::decrypt($request->cxslug);
        $resetPassword= CustomerLogin::where('customer_slug', '=', $decryptCXSlug)->
                update(['password' => Hash::make($request->password)]);
        if($resetPassword){
            return redirect()->route('cxlogin')->with('message','Yes! You have successfully reset the password, Please use your mobile number as a user ID & new password to login');
        }else{
            echo "error";
        }
    }
}
