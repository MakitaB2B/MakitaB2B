<?php
namespace App\Services;
use App\Models\Admin\AssetMaster;
class AssetMasterService{
    public function getAllAssetMasterWithEmp(){
        return AssetMaster::with(['employee:employee_slug,full_name'])->select('asset_tag','asset_type','make','model','serial_number','service_tag','status','updated_by','assetmaster_slug')->get();
    }
    public function findAssetMasterBySlug($slug){
        return AssetMaster::where(['assetmaster_slug'=>$slug])->get();
    }
    public function createOrUpdateAssetMaster($id,$request,$assetmasterSlug,$dataOparateEmpSlug,$invoicecopy){
        $operate=AssetMaster::updateOrCreate(
            ['id' =>$id],
            ['asset_tag'=> $request->asset_tag,'asset_type'=>$request->asset_type,'make'=>$request->make,'model'=>$request->model,'serial_number'=>$request->serial_number,
            'service_tag'=>$request->service_tag,'specification'=>$request->specification,'ram'=>$request->ram,'hard_disk_type'=>$request->hard_disk_type,
            'hard_disk_size'=>$request->hard_disk_size,'processor'=>$request->processor,'operating_system_version'=>$request->operating_system_version,
            'operating_system_serial_number'=>$request->operating_system_serial_number,
            'ms_office_version'=>$request->ms_office_version,'ms_office_licence'=>$request->ms_office_licence,'vendor_name'=>$request->vendor_name,'invoice_number'=>$request->invoice_number,
            'invoice_date'=>$request->invoice_date,'amount'=>$request->amount,'warranty_period'=>$request->warranty_period,'warranty_expired_date'=>$request->warranty_expired_date,
            'system_condition'=>$request->system_condition,'service_replacement'=>$request->service_replacement,'system_password'=>$request->system_password,'invoice_copy'=>$invoicecopy,
            'remarks'=>$request->remarks,'status'=>$request->status,'assetmaster_slug'=>$assetmasterSlug,'updated_by'=>$dataOparateEmpSlug]
         );
         if($operate){
            return true;
         }
    }
    public function findAssetDataExistence($field,$assetTag){
        return AssetMaster::where([$field=>$assetTag])->exists();
    }

}
?>
