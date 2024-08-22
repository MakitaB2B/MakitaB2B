<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PromotionService;
use App\Services\TransactionService;
use App\Services\RegionalMangerService;
use App\Services\DealerService;
use App\Models\Admin\BranchStocks;
use Auth;
use Carbon\Carbon;

class PromotionController extends Controller
{
    protected $promotionService;
    protected $transactionService;

    public function __construct(PromotionService $promotionService,TransactionService $transactionService,RegionalMangerService $regionalManager,DealerService $dealerService){
      $this->promotionService=$promotionService;
      $this->transactionService=$transactionService;
      $this->regionalManager=$regionalManager;
      $this->dealerService=$dealerService;
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
      $offer_model = $request->offermodel ?? [];
      $offer_mrp = $request->promomrp;
      $offer_dlp = $request->promodlp;
      $offer_stock = $request->promostock;
      $offer_offertype = $request->offertype;
      $offer_offerqty = $request->offerqty;
      $offer_pricetype = $request->pricetype;
      $offer_promoprice = $request->promoprice;
      $foc_model = $request->focmodel ?? [];
      $focdescription = $request->focdescription;
      $offerdescription = $request->offerdescription;
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
              'model_desc'=>$offerdescription[$key],
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
            'model_desc'=>$focdescription[$key],
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

      $result['promo_code']=$this->promotionService->activePromotion();
      $result['regional_manager']=$this->regionalManager->rmNames();
      $result['dealer_master']=$this->dealerService->getDealers();

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

      $result["data"] = $this->promotionService->getPromoDeatils($promoID);
     
      return response()->json($result);
    }

    public function transactionVerify(Request $request){

      $data_array = $request->input('data') ? json_decode($request->input('data'), true) : [];

      $promoID = $request->input('promocode'); 
      $promodata = $this->promotionService->getPromoDeatils($promoID);
      $buyoneoftheproductflag = 0;$comboofferflag = 0;
      foreach ($data_array  as $subArray) {
        if (isset($subArray["offertype"]) && $subArray["offertype"] === "Buy One Of The Product") {
            $buyoneoftheproductflag=1;
            break;
        }
        elseif(isset($subArray["offertype"]) && $subArray["offertype"] === "Combo Offer"){
          $comboofferflag=1;
          break;
        }
      }
 
      $data_array = array_filter($data_array, function($item) {
        return $item['offertype']!="null";
      });
      $promomodeldata=$promodata->where("model_no",$data_array[0]["model_no"]);
      $multiplesof=$data_array[0]['qty']/$promomodeldata->first()->qty;
      if($buyoneoftheproductflag==1 && count($data_array)==1){
    
        if($data_array[0]['qty']%$promomodeldata->first()->qty==0){

        $filteredPromos = $promodata->filter(function ($promo) use ($data_array, $multiplesof) {
          $promo->qty = $promo->qty*$multiplesof;
          $promo->price= $promo->qty*$promo->price;
          if( $promo->stock<$promo->qty){
            $result["total_price"] =  "stock unavialable";
              return false; 
          }
          return $promo->model_no == $data_array[0]['model_no'] || $promo->product_type == 'FOC';
        });

        }
      
        $result["total_price"] =  $filteredPromos->sum('price');
        
      }elseif($comboofferflag==1 && count($data_array)>1){

        $filteredPromos = $promodata->filter(function ($promo) use ($data_array, $multiplesof) {
          $promo->qty = $promo->qty*$multiplesof;
          $promo->price= $promo->qty*$promo->price;
          if( $promo->stock<$promo->qty){
            $result["total_price"] =  "stock unavialable";
              return false; 
          }
          return true;
        });
        $result["total_price"] =  $filteredPromos->sum('price');


      }else{
        $result["total_price"] =  "invalid input";
      }

      dd($result["total_price"]);
      return response()->json($result);
    }

}
