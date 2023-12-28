<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService){
        $this->productService=$productService;
    }
    public function index(){
        $productList=$this->productService->getAllProducts();
        return view('Admin.products',['products'=>$productList]);
    }
    public function manageProduct($productslug = '')
    {
        if ($productslug > 0) {
            $decripedProdSlug = Crypt::decrypt($productslug);
            $arr = $this->productService->findProductBySlug($decripedProdSlug);
            $result['category_id']=$arr[0]->category_id;
            $result['model'] = $arr[0]->model;
            $result['name'] = $arr[0]->name;
            $result['product_slug'] = Crypt::encrypt($arr[0]->product_slug);
            $result['product_price'] = $arr[0]->product_price;
            $result['primary_image'] = $arr[0]->primary_image;
            $result['short_description'] = $arr[0]->short_description;
            $result['long_description'] = $arr[0]->long_description;
            $result['technical_info'] = $arr[0]->technical_info;
            $result['general_info'] = $arr[0]->general_info;
            $result['support'] = $arr[0]->support;
            $result['video_link'] = $arr[0]->video_link;
            $result['keywords'] = $arr[0]->keywords;
            $result['warranty'] = $arr[0]->warranty;
            $result['status'] = $arr[0]->status;
            $result['tax_id'] = $arr[0]->tax_id;
            $result['categories']=$this->productService->findActiveCategories();
        } else {
            $result['category_id']='';
            $result['model'] = '';
            $result['name'] = '';
            $result['product_slug'] = Crypt::encrypt(0);
            $result['product_price'] = '';
            $result['primary_image'] = '';
            $result['short_description'] = '';
            $result['long_description'] = '';
            $result['technical_info'] = '';
            $result['general_info'] = '';
            $result['support'] = '';
            $result['video_link'] = '';
            $result['keywords'] = '';
            $result['warranty'] = '';
            $result['status'] = '';
            $result['tax_id'] = '';
            $result['categories']=$this->productService->findActiveCategories();
        }
        return view('Admin.manage_products', $result);
    }
    public function manageProductProcess(Request $request){
        $decripedSlug = Crypt::decrypt($request->product_slug);
        if($decripedSlug>0){
            $rowData=$this->productService->findProductBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $slug=$rowData[0]->product_slug;
            if($request->has('primary_image')){
                $productImage=$rowData[0]->primary_image;
                if(Storage::exists($productImage)){
                    Storage::delete($productImage);
                    $productImage=$request->file('primary_image')->store('mimes/products');
                }
            }else{
                $productImage=$rowData[0]->primary_image;
            }
        }else{
            $id=0;
            $slug=Str::slug($request->name.rand());
            if($request->has('primary_image')){
                $productImage=$request->file('primary_image')->store('mimes/products');
            }else{
                $productImage='';
            }
        }
        $data = $request->validate([
            'name' => 'required|min:2|max:250',
            'status' => 'required|numeric',
            'category_id' => 'numeric',
        ]);
        if($data){
            $createUpdateAction=$this->productService->createOrUpdateProduct($id,$request,$slug,$productImage);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Product sucessfully updated';
                 }
                 else{
                    $msg='Product sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/product');
            }
         }
    }
}
