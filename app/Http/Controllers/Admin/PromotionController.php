<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Crypt;
// use Illuminate\Support\Str;
use Auth;

class PromotionController extends Controller
{
    // protected $assetMasterService;
    // public function __construct(){
      
    // }
    public function index(){
        // $promotionList=$this->assetMasterService->getAllAssetMasterWithEmp();
        return view('Admin.promotion'); // ,compact('promotionList')
    }

    public function promotionCreation()
    {
      $result['offer_type'] = ['solo offer','combo offer'];
      $result['price_type'] = ['DLP','best price','special price',];
      return view('Admin.promotion_creation', $result); 
    }

    public function promotionPreview()
    {
      return view('Admin.promotion_preview');
    }

    public function transactionCreation(){
      return view('Admin.transaction');
    }
    public function promotionTransaction(){
      return view('Admin.promotion_transaction');
    }

    public function getPromo(Request $request){

      $promoID = $request->input('promoID');

      $promo_products= [
        "0"=>[
        "offer_product"=>[
          "0"=>[
            "PROMOCode" => "promocode1",
            "ModelName" => "xyz",
            "OfferDescription" => "desc",
            "MRP"=>"2345",
            "DLP"=>"23458",
            "Stock"=>"4678",
            "PriceType" => "Special Price",
            "OfferQty"=>"2",
            "Price"=>"1245"
          ],
          "1"=>[
            "PROMOCode" => "promocode1",
            "ModelName" => "xyzh",
            "OfferDescription" => "desc jhh",
            "MRP"=>"23456",
            "DLP"=>"23457",
            "Stock"=>"4678",
            "PriceType" => "Special Price",
            "OfferQty"=>"3",
            "Price"=>"1245"
          ]

        ],
        "foc"=>[
          "0"=>[ 
          "PROMOCode" => "promocode1",
          "ModelName" => "xyz",
          "OfferDescription" => "desc",
          "MRP"=>"2345",
          "DLP"=>"23458",
          "Stock"=>"4678",
          "PriceType" => "Special Price",
          "OfferQty"=>"2",
          "Price"=>"1245"
        ],
          "1"=>[ 
          "PROMOCode" => "promocode1",
          "ModelName" => "xyz",
          "OfferDescription" => "desc",
          "MRP"=>"2345",
          "DLP"=>"23458",
          "Stock"=>"4678",
          "PriceType" => "Special Price",
          "OfferQty"=>"2",
          "Price"=>"1245"
          ]
        ]
        ]

      ];
      return response()->json($promo_products);
    }



}
