<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Front\WarrantyRegistration;
use Illuminate\Support\Facades\Crypt;
use App\Models\Admin\ProductModel;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;


class WarrantyController extends Controller
{
    public function warrantyCard($modelID='',$slno=''){
        $result['modelID']=$modelID;
        $result['slno']=$slno;
        $decodeModelNumber=base64_decode($modelID);
        $result['models']=ProductModel::where('id','=',$decodeModelNumber)->get(['id','model_number','warranty_period']);
        return view('Front.warranty_card',$result);
    }
    public function warrantyCardProcess(Request $request){
        $data = $request->validate([
            'mode_of_purchase' => ['required',Rule::in('online','offline')],
            'purchase_from' => 'required|min:2|max:250',
            'place_of_purchase' => 'required|min:2|max:250',
            'date_of_purchase' => 'required|date_format:Y-m-d',
            'model_number' => 'required',
            'invoice_number' => 'required',
            'machine_serial_number' => 'required',
            'machine_slno_photo' => 'required|mimes:jpg,jpeg,png',
        ]);
        if($data){
            $cxSlug=Auth::guard('customer')->user()->customer_slug;
            if($request->has('machine_slno_photo')){
                $mSP=$request->file('machine_slno_photo')->store('mimes/warranty');
            }
            if($request->has('invoice_copy')){
                $invoiceCopy=$request->file('invoice_copy')->store('mimes/warranty');
            }else{
                $invoiceCopy='';
            }
            $modelData=ProductModel::where('id','=',$request->model_number)->get();
            $warrantyExpiryDate=$modelData[0]->warranty_period;
            $dop=$request->date_of_purchase;
            $warrantyExpiryDate = Carbon::create($dop)->addMonths($warrantyExpiryDate);
            $today = date('Y-m-d H:i:s');
            if($today>$warrantyExpiryDate){
                $warrantyStatus=0;
            }else{
                $warrantyStatus=1;
            }
            $model = new WarrantyRegistration();
            $model->customer_slug = $cxSlug;
            $model->mode_of_purchase = $request->mode_of_purchase;
            $model->purchase_from = $request->purchase_from;
            $model->place_of_purchase = $request->place_of_purchase;
            $model->date_of_purchase = $request->date_of_purchase;
            $model->warranty_expiry_date = $warrantyExpiryDate;
            $model->model_number = $request->model_number;
            $model->invoice_number = $request->invoice_number;
            $model->machine_serial_number = $request->machine_serial_number;
            $model->invoice_copy = $invoiceCopy;
            $model->machine_slno_photo = $mSP;
            $model->comment = $request->comment;
            $model->warranty_status = $warrantyStatus;
            $model->warranty_slug =Str::slug(rand().rand());
            if($model->save()){
                $cxSlug=$model->customer_slug;
                return redirect('cx-signup-details');
            }else{
                return redirect('cx-warranty-registration-fairmsg/'.Crypt::encrypt($warntyAppSlug));
            }

        }
    }
    public function warrantyRegistrationUtterMsg(){
        return view('Front.warranty_registration_fairmsg');
    }
    public function getAllWarrantyApplications(){
        $warrantyAppData= WarrantyRegistration::with('model:id,model_number')->orderBy('id','desc')->get();
        return view('Admin.warranty-apllications',compact('warrantyAppData'));
    }
    public function changeWarrantyApplicationStatus(Request $request){
        $status=$request->status;
        $slug=$request->slug;
        $empSlug=Auth::guard('admin')->user()->employee_slug ;
        $updateStatus= WarrantyRegistration::where('warranty_slug', $slug)->update(['application_status' => $status,'application_status_reviewed_by'=>$empSlug]);
        if($updateStatus){
            echo "sucess";
        }
    }
    public function manageWarrantyApplication($warrantySlug = '')
    {
        $decripedWarrantyAppSlug = Crypt::decrypt($warrantySlug);
        $arr =  WarrantyRegistration::where('warranty_slug', $decripedWarrantyAppSlug)->get();
        $result['mode_of_purchase'] = $arr[0]->mode_of_purchase;
        $result['purchase_from'] = $arr[0]->purchase_from;
        $result['place_of_purchase'] = $arr[0]->place_of_purchase;
        $result['date_of_purchase'] = $arr[0]->date_of_purchase;
        $result['warranty_expiry_date'] = $arr[0]->warranty_expiry_date;
        $result['model_number'] = $arr[0]->model_number;
        $result['invoice_number'] = $arr[0]->invoice_number;
        $result['machine_serial_number'] = $arr[0]->machine_serial_number;
        $result['invoice_copy'] = $arr[0]->invoice_copy;
        $result['machine_slno_photo'] = $arr[0]->machine_slno_photo;
        $result['comment'] = $arr[0]->comment;
        return view('Admin.manage_warranty_application', $result);
    }
    public function scanningMachineBcode(){
        $result['models']=ProductModel::get(['id','model_number','warranty_period']);
        return view('Front.warranty_scan_machine',$result);
    }
    public function getProductSpecificModelDetails(Request $request){
        $modelData=ProductModel::where('model_number','=',$request->model)->get();
        if($modelData){
            return $modelData[0]->id;
        }else{
            return 0;
        }
    }
    public function checkSerialNumberExistence(Request $request){
        if (WarrantyRegistration::where('machine_serial_number', '=', $request->slno)->exists()) {
            return 1;
        }else{
            return 0;
        }
    }
    public function getWarrantyListForSpecCX(){
        $cxSlug=Auth::guard('customer')->user()->customer_slug;
        $result =  WarrantyRegistration::with('model:id,model_number,warranty_period')
        ->where('customer_slug', $cxSlug)->orderBy('id','desc')
        ->get(['id','model_number','invoice_number','machine_serial_number','application_status','date_of_purchase','warranty_expiry_date']);
        return view('Front.customer_prod_warranty_list', compact('result'));
    }
}
