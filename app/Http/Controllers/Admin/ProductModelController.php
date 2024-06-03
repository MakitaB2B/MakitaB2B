<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductModelService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Auth;

class ProductModelController extends Controller
{
    protected $productModelService;
    public function __construct(ProductModelService $productModelService){
        $this->productModelService=$productModelService;
    }
    public function index(){
        $productModelList=$this->productModelService->getAllProductModelsWithCreatedBy();
        return view('Admin.product_model',['productModelList'=>$productModelList]);
    }
    public function manageProductModelSlug($productmodelslug = ''){
        if ($productmodelslug > 0) {
            $decripedProduCtModelSlug = Crypt::decrypt($productmodelslug);
            $arr = $this->productModelService->findProductModelBySlug($decripedProduCtModelSlug);
            $result['model_number'] = $arr[0]->model_number;
            $result['description'] = $arr[0]->description;
            $result['warranty_period'] = $arr[0]->warranty_period;
            $result['category'] = $arr[0]->category;
            $result['product_code'] = $arr[0]->product_code;
            $result['status'] = $arr[0]->status;
            $result['model_slug'] = Crypt::encrypt($arr[0]->model_slug);
        } else {
            $result['model_number'] = '';
            $result['description'] = '';
            $result['warranty_period'] = '';
            $result['category'] = '';
            $result['product_code'] = '';
            $result['status'] = '';
            $result['model_slug'] = Crypt::encrypt(0);
        }
        return view('Admin.manage_product_model', $result);
     }
     public function manageProductModelProcess(Request $request){
        $decripedSlug = Crypt::decrypt($request->product_model_slug);
        if($decripedSlug>0){
            $rowData=$this->productModelService->findProductModelBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $slug=$rowData[0]->model_slug;
        }else{
            $id=0;
            $slug=Str::slug($request->name.rand());
        }
        $data = $request->validate([
            'model_number' => 'required|min:2|max:250|unique:product_models,model_number,'.$id,
            'description' => 'required',
            'warranty_period' => 'required',
            'category' => 'required',
            'product_code' => 'required',
            'status' => 'required|numeric',
        ]);
        if($data){
            $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug;
            $createUpdateAction=$this->productModelService->createOrUpdateProductModel($id,$request,$slug,$dataOparateEmpSlug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Product Model sucessfully updated';
                 }
                 else{
                    $msg='Product Model sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/productmodel');
            }
         }
    }
}
