<?php
namespace App\Services;
use App\Models\Admin\ProductModel;
use Illuminate\Support\Facades\DB;
class ProductModelService{
    public function getAllProductModelsWithCreatedBy(){
        return ProductModel::with(['employee:employee_slug,full_name'])->select('model_number','description','warranty_period','model_slug','status','category','product_code','created_by')->orderBy('id','desc')->get();
    }
    public function findProductModelBySlug($slug){
        return ProductModel::where(['model_slug'=>$slug])->get();
    }
    public function createOrUpdateProductModel($id,$request,$slug,$dataOparateEmpSlug){
        $operate=ProductModel::updateOrCreate(
            ['id' =>$id],
            ['model_number'=> $request->model_number,'description'=>$request->description,'warranty_period'=>$request->warranty_period,
            'category'=>$request->category,'product_code'=>$request->product_code,'status'=>$request->status,'model_slug'=>$slug,'created_by'=>$dataOparateEmpSlug]
         );
         if($operate){
            return true;
         }
    }
}
?>
