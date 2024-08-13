<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PromotionService;
use App\Services\TransactionService;
use App\Models\Admin\BranchStocks;
use Auth;

class PromotionController extends Controller
{
    protected $promotionService;
    protected $transactionService;

    public function __construct(PromotionService $promotionService,TransactionService $transactionService){
      $this->promotionService=$promotionService;
      $this->transactionService=$transactionService;
    }

    public function index(){
        return view('Admin.promotion'); 
    }

    public function promotionCreation()
    { 
      $result['promo_code'] = $this->promotionService->getPromoCount()+1;
      $result['offer_type'] = ['solo offer','combo offer'];
      $result['price_type'] = ['DLP','best price','special price'];
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
    
    public function searchData(Request $request)
    {
        $query = $request->get('q');
        $results = $this->promotionService->searchData($query);

        return  $results;
    }

    public function modeldetailSearch(Request $request){

      $query = $request->get('searchtxt');
      $results = $this->promotionService->modeldetailSearch($query);

      return $results;
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
