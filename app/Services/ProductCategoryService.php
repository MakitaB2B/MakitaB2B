<?php
namespace App\Services;
use App\Models\Admin\ProductsCategories;
class ProductCategoryService{
    public function getAllProductsCategories(){
        $parentCategories = ProductsCategories::with('children')->get();
        return $parentCategories;
    }
    public function findProductCategoryBySlug($slug){
        return ProductsCategories::where(['category_slug'=>$slug])->get();
    }
    public function createOrUpdateProductCategory($id,$request,$slug,$categoryImage){
        $operate=ProductsCategories::updateOrCreate(
            ['id' =>$id],
            ['category_name'=> $request->category_name,'category_slug'=>$slug,
            'parent_category_id'=>$request->parent_category_id, 'category_image'=>$categoryImage,
            'status'=>$request->status]
         );
         if($operate){
            return true;
         }
    }

}
?>
