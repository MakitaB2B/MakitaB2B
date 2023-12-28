<?php
namespace App\Services;
use App\Models\Admin\Product;
use Illuminate\Support\Facades\DB;
class ProductService{
    public function getAllProducts(){
        return Product::orderBy('id','desc')->get();
    }
    public function findProductBySlug($slug){
        return Product::where(['product_slug'=>$slug])->get();
    }
    public function createOrUpdateProduct($id,$request,$slug,$productImage){
        $operate=Product::updateOrCreate(
            ['id' =>$id],
            ['category_id'=> $request->category_id,'model'=>$request->model,
            'name'=>$request->name, 'product_slug'=>$slug,
            'product_price'=>$request->product_price,'primary_image'=>$productImage,
            'short_description'=>$request->short_description,'long_description'=>$request->long_description,
            'technical_info'=>$request->technical_info,'general_info'=>$request->general_info,
            'support'=>$request->support,'video_link'=>$request->video_link,'keywords'=>$request->keywords,
            'warranty'=>$request->warranty,'status'=>$request->status,'tax_id'=>$request->tax_id]
         );
         if($operate){
            return true;
         }
    }
    public function findActiveCategories(){
        return DB::table('products_categories')->where(['status'=>1])->get();
    }

}
?>
