<?php
namespace App\Services;
use App\Models\Admin\DemoVan;
class DemoVanService{
  
    public function demoVanDetails($state){
        return DemoVan::where('state',$state)->pluck('vehicles_reg_no'); //->where('purpose','Demo')->where('used_by','Sales')
    }
  

}
?>
