<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductCategoryService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    protected $productCategoryService;
    public function __construct(ProductCategoryService $productCategoryService){
        $this->productCategoryService=$productCategoryService;
    }
    public function index(){
        $productsCategories=$this->productCategoryService->getAllProductsCategories();
        return view('Admin.products_categories',['productsCategories'=>$productsCategories]);
    }
    public function manageProductCategory($prodcateslug = '')
    {
        if ($prodcateslug > 0) {
            $decripedProdCateSlug = Crypt::decrypt($prodcateslug);
            $arr = $this->productCategoryService->findProductCategoryBySlug($decripedProdCateSlug);
            $result['category_name'] = $arr[0]->category_name;
            $result['parent_category_id'] = $arr[0]->parent_category_id;
            $result['category_image'] = $arr[0]->category_image;
            $result['status'] = $arr[0]->status;
            $result['category_slug'] = Crypt::encrypt($arr[0]->category_slug);
            $result['allcategories']=$this->productCategoryService->getAllProductsCategories();
        } else {
            $result['category_name'] = '';
            $result['parent_category_id'] = '';
            $result['category_image'] = '';
            $result['category_slug'] = Crypt::encrypt(0);
            $result['status'] = '';
            $result['allcategories']=$this->productCategoryService->getAllProductsCategories();
        }
        return view('Admin.manage_products_categories', $result);
    }
    public function manageProductCategoryProcess(Request $request){
        $decripedSlug = Crypt::decrypt($request->category_slug);
        if($decripedSlug>0){
            $rowData=$this->productCategoryService->findProductCategoryBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $slug=$rowData[0]->category_slug;
            if($request->has('category_image')){
                $categoryImage=$rowData[0]->category_image;
                if(Storage::exists($categoryImage)){
                    Storage::delete($categoryImage);
                    $categoryImage=$request->file('category_image')->store('mimes/product_category');
                }
            }else{
                $categoryImage=$rowData[0]->category_image;
            }
        }else{
            $id=0;
            $slug=Str::slug($request->category_name.rand());
            if($request->has('category_image')){
                $categoryImage=$request->file('category_image')->store('mimes/product_category');
            }else{
                $categoryImage='';
            }
        }
        $data = $request->validate([
            'category_name' => 'required|min:2|max:250',
            'status' => 'required|numeric',
            'parent_category_id' => 'numeric',
        ]);
        if($data){
            $createUpdateAction=$this->productCategoryService->createOrUpdateProductCategory($id,$request,$slug,$categoryImage);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Product category sucessfully updated';
                 }
                 else{
                    $msg='Product category sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/productcategory');
            }
         }
    }
}
