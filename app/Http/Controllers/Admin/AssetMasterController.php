<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AssetMasterService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Auth;

class AssetMasterController extends Controller
{
    protected $assetMasterService;
    public function __construct(AssetMasterService $assetMasterService){
        $this->assetMasterService=$assetMasterService;
    }
    public function index(){
        $assetMasterList=$this->assetMasterService->getAllAssetMasterWithEmp();
        return view('Admin.asset_master',compact('assetMasterList'));
    }
    public function manageAssetMaster($assetMasterSlug = '')
    {
        if ($assetMasterSlug > 0) {
            $decripedAssetMasterSlug = Crypt::decrypt($assetMasterSlug);
            $arr = $this->assetMasterService->findAssetMasterBySlug($decripedAssetMasterSlug);
            $result['asset_tag'] = $arr[0]->asset_tag;
            $result['asset_type'] = $arr[0]->asset_type;
            $result['make'] = $arr[0]->make;
            $result['model'] = $arr[0]->model;
            $result['serial_number'] = $arr[0]->serial_number;
            $result['service_tag'] = $arr[0]->service_tag;
            $result['specification'] = $arr[0]->specification;
            $result['ram'] = $arr[0]->ram;
            $result['hard_disk_type'] = $arr[0]->hard_disk_type;
            $result['hard_disk_size'] = $arr[0]->hard_disk_size;
            $result['processor'] = $arr[0]->processor;
            $result['operating_system_version'] = $arr[0]->operating_system_version;
            $result['operating_system_serial_number'] = $arr[0]->operating_system_serial_number;
            $result['ms_office_version'] = $arr[0]->ms_office_version;
            $result['ms_office_licence'] = $arr[0]->ms_office_licence;
            $result['vendor_name'] = $arr[0]->vendor_name;
            $result['invoice_number'] = $arr[0]->invoice_number;
            $result['invoice_date'] = $arr[0]->invoice_date;
            $result['amount'] = $arr[0]->amount;
            $result['warranty_period'] = $arr[0]->warranty_period;
            $result['warranty_expired_date'] = $arr[0]->warranty_expired_date;
            $result['system_condition'] = $arr[0]->system_condition;
            $result['service_replacement'] = $arr[0]->service_replacement;
            $result['system_password'] = $arr[0]->system_password;
            $result['remarks'] = $arr[0]->remarks;
            $result['status'] = $arr[0]->status;
            $result['updated_at'] = $arr[0]->updated_at;
            $result['invoice_copy'] = $arr[0]->invoice_copy;
            $result['assetmaster_slug'] = Crypt::encrypt($arr[0]->assetmaster_slug);
        } else {
            $result['asset_tag'] = '';
            $result['asset_type'] = '';
            $result['make'] = '';
            $result['model'] = '';
            $result['serial_number'] = '';
            $result['service_tag'] = '';
            $result['specification'] = '';
            $result['ram'] = '';
            $result['hard_disk_type'] = '';
            $result['processor'] = '';
            $result['hard_disk_size'] = '';
            $result['operating_system_version'] = '';
            $result['operating_system_serial_number'] = '';
            $result['ms_office_version'] = '';
            $result['ms_office_licence'] = '';
            $result['vendor_name'] = '';
            $result['invoice_number'] = '';
            $result['invoice_date'] = '';
            $result['amount'] = '';
            $result['warranty_period'] = '';
            $result['warranty_expired_date'] = '';
            $result['system_condition'] = '';
            $result['service_replacement'] = '';
            $result['system_password'] = '';
            $result['remarks'] = '';
            $result['status'] = '';
            $result['updated_at'] = '';
            $result['invoice_copy'] = '';
            $result['assetmaster_slug'] = Crypt::encrypt(0);
        }
        return view('Admin.manage_asset_master', $result);
    }
    public function createOrUpdateAssetMaster(Request $request){
        $decripedSlug = Crypt::decrypt($request->assetmaster_slug);
        if($decripedSlug>0){
            $rowData=$this->assetMasterService->findAssetMasterBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $assetmasterSlug=$rowData[0]->assetmaster_slug;

             if($request->has('invoicecopy')){
                $invoicecopy=$rowData[0]->invoice_copy;
                if($invoicecopy==NULL){
                    $invoicecopy=$request->file('invoicecopy')->store('mimes/company_assets');
                }
                if($invoicecopy!=NULL && Storage::exists($invoicecopy)){
                    Storage::delete($invoicecopy);
                    $invoicecopy=$request->file('invoicecopy')->store('mimes/company_assets');
                }
            }else{
                $invoicecopy=$rowData[0]->invoice_copy;
            }

        }else{
            $id=0;
            $assetmasterSlug=Str::slug(rand().rand());

            if($request->has('invoicecopy')){
                $invoicecopy=$request->file('invoicecopy')->store('mimes/company_assets');
            }else{
                $invoicecopy='';
            }
        }
        $data = $request->validate([
            'asset_tag' => 'required|min:2|max:250',
            'asset_type' => 'required|min:2|max:250',
            'make' => 'required|min:2|max:250',
            'model' => 'required|min:2|max:250',
            'serial_number' => 'required|min:2|max:250',
        ]);
        if($data){
            $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug ;
            $createUpdateAction=$this->assetMasterService->createOrUpdateAssetMaster($id,$request,$assetmasterSlug,$dataOparateEmpSlug,$invoicecopy);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Asset sucessfully updated';
                 }
                 else{
                    $msg='Asset sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/asset-master');
            }
         }
    }
    public function checkAssetTagExistance(Request $request){
        $assetTag=$request->assettag;
        $field='asset_tag';
        $count=$this->assetMasterService->findAssetDataExistence($field,$assetTag);
        if($count==1)
        {
			echo "<b style='color:red;'>Asset Tag Not Available</b>";
		}
        if($count=='')
        {
			echo "<b style='color:green;'>Asset Tag Available</b>";
		}
    }
    public function checkMSOfficeLicenceExistance(Request $request){
        $msOfficeLicence=$request->msOfficeLicence;
        $field='ms_office_licence';
        $count=$this->assetMasterService->findAssetDataExistence($field,$msOfficeLicence);
        if($count==1)
        {
			echo "<b style='color:red;'>MS Office Licence Not Available</b>";
		}
        if($count=='')
        {
			echo "<b style='color:green;'>MS Office Licence Available</b>";
		}
    }
    public function operatingSystemSerialNumberExistance(Request $request){
        $operatingSystemSerialNumber=$request->operatingsystemserialnumber;
        $field='operating_system_serial_number';
        $count=$this->assetMasterService->findAssetDataExistence($field,$operatingSystemSerialNumber);
        if($count==1)
        {
			echo "<b style='color:red;'>OS Serial Number Not Available</b>";
		}
        if($count=='')
        {
			echo "<b style='color:green;'>OS Serial Number Available</b>";
		}
    }
}
