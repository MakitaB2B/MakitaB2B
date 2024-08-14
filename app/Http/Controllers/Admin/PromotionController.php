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
      $result['offer_type'] = ['Buy One Of The Product','Combo Offer'];
      $result['price_type'] = ['DLP','best price','special price'];
      return view('Admin.promotion_creation', $result); 
    }

    public function promotionCreate(Request $request){
         dd($request->all());
      $promocode = $request->promocode;
      $from_date = $request->promo_from_date;
      $to_date = $request->promo_to_date;
      $offer_model = $request->offermodel;
      $offer_mrp = $request->promomrp;
      $offer_dlp = $request->promodlp;
      $offer_stock = $request->promostock;
      $offer_offertype = $request->offertype;
      $offer_offerqty = $request->offerqty;
      $offer_pricetype = $request->pricetype;
      $offer_promoprice = $request->promoprice;
      $foc_model = $request->focmodel;
      $foc_promomrp = $request->focpromomrp;
      $foc_promodlp = $request->focpromodlp;
      $foc_stock = $request->focstock;
      $foc_qty = $request->focqty;
      $foc_specialprice = $request->focspecialprice;

    $data = [];

      foreach ($offer_model as $key => $model) {
          $data[] = [
              'promotion_slug' => $this->promotionService->promotion_slug(),
              'promo_code' => $promocode,
              'from_date' => $from_date,
              'to_date' =>  $to_date,
              'model_no' => $offer_model[$key],
              'product_type' => "FOC",
              'qty' => $offer_offerqty[$key] ,
              'price' => $offer_promoprice[$key],
              'offer_type'=>$offer_offertype[$key],
              'mrp'=>$offer_mrp[$key],
              'dlp'=>$offer_dlp[$key],
              'stock'=>$offer_stock[$key]
          ];
      }


      foreach ( $foc_model as $key => $model) {
        $data[] = [
            'promotion_slug' => $this->promotionService->promotion_slug(),
            'promo_code' => $promocode,
            'from_date' => $from_date,
            'to_date' =>  $to_date,
            'model_no' => $foc_model[$key],
            'product_type' => "FOC",
            'qty' => $foc_qty[$key] ,
            'price' =>  $foc_specialprice[$key],
            'offer_type'=>'special price',
            'mrp'=>$foc_promomrp[$key],
            'dlp'=> $foc_promodlp[$key],
            'stock'=>$foc_stock[$key]
        ];
    }
        
    $this->promotionService->createOrUpdatePromo($data);

    return redirect('admin/promotions');

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

    public function modeldetailSingleSearch(Request $request){

      $query = $request->get('searchtxt');
      $results = $this->promotionService->modeldetailSingleSearch($query);

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
