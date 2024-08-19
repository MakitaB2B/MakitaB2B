<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PromotionService;
use App\Services\TransactionService;
use App\Models\Admin\BranchStocks;
use Auth;
use Carbon\Carbon;

class PromotionController extends Controller
{
    protected $promotionService;
    protected $transactionService;

    public function __construct(PromotionService $promotionService,TransactionService $transactionService){
      $this->promotionService=$promotionService;
      $this->transactionService=$transactionService;
    }

    public function index(){

      $result['promo_list']=$this->promotionService->listPromotions();
      return view('Admin.promotion',$result); 
    }

    public function promotionCreation()
    { 
      $result['promo_code'] = $this->promotionService->getPromoCount()+1;
      $result['offer_type'] = ['Buy One Of The Product','Combo Offer'];
      $result['price_type'] = ['DLP','best price','special price'];
      return view('Admin.promotion_creation', $result); 
    }

    public function promotionCreate(Request $request){

      $validated_data= $request->validate([
        'promo_from_date' => 'required|date',
        'promo_to_date' => 'required|date|after_or_equal:promo_from_date',
        'promocode' => 'required|unique:promotions,promo_code',
      ]);

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
      $status = (Carbon::now()->between($from_date, $to_date)) ? 'active' : null;

    $data = [];

      foreach ($offer_model as $key => $model) {
          $data[] = [
              'promotion_slug' => $this->promotionService->promotion_slug(),
              'promo_code' => $promocode,
              'from_date' => $from_date,
              'to_date' =>  $to_date,
              'model_no' => $offer_model[$key],
              'product_type' => "Offer Product",
              'qty' => $offer_offerqty[$key] ,
              'price' => $offer_promoprice[$key],
              'offer_type'=>$offer_offertype[$key],
              'price_type'=> ($offer_pricetype[$key] == 'DLP') ? 'DLP' : (($offer_pricetype[$key] == 'best price') ? 'Best Price' : 'Special Price'),
              'mrp'=>$offer_mrp[$key],
              'dlp'=>$offer_dlp[$key],
              'stock'=>$offer_stock[$key],
              'status'=> $status,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
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
            'offer_type' => null,
            'price_type'=>'Special Price',
            'mrp'=>$foc_promomrp[$key],
            'dlp'=> $foc_promodlp[$key],
            'stock'=>$foc_stock[$key],
            'status'=> $status,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
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

      $result['promo_code']=BranchStocks::limit(500)->get();
      return view('Admin.promotion_transaction',$result);
    }

    public function promotionTransaction(){
      // $result['promo_code']=BranchStocks::limit(500)->get();
      return view('Admin.transaction');
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
