<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PromotionService;
use App\Services\TransactionService;
use App\Services\RegionalMangerService;
use App\Services\DealerService;
use App\Services\DealerCancelledService;
use App\Models\Admin\BranchStocks;
use Auth;
use Carbon\Carbon;
use App\Models\Admin\Transaction;
use Illuminate\Support\Facades\Crypt;
use App\Jobs\PromoJob;

class PromotionController extends Controller
{
    protected $promotionService;
    protected $transactionService;

    public function __construct(PromotionService $promotionService,TransactionService $transactionService,RegionalMangerService $regionalManager,DealerService $dealerService,DealerCancelledService $dealerCancelledService){
      $this->promotionService=$promotionService;
      $this->transactionService=$transactionService;
      $this->regionalManager=$regionalManager;
      $this->dealerService=$dealerService;
      $this->dealerCancelledService=$dealerCancelledService;
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
      $emp_no = Auth::guard('admin')->user()->access_id;

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
              'created_by'=>$emp_no,
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
            'created_by'=>$emp_no,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
    }

    $this->promotionService->createOrUpdatePromo($data);

    return redirect('admin/promotions');

    }

    public function promotionPreview($id)
    {
      $promo_code = Crypt::decrypt($id);
      $promotion = $this->promotionService->getPromoDeatilsWithStock($promo_code);
      $result['focproduct'] = $promotion->where('product_type','FOC')->values();
      $result['offerproduct'] = $promotion->where('product_type','Offer Product')->values();
      $result['textfromatmodelqty'] = $this->textFormatModelQty($result['offerproduct']->toArray(),$result['focproduct']->toArray());
      $result['status'] = ['active','closed'];

      return view('Admin.promotion_preview',$result);
    }

    public function changeStatus(Request $request)
    {
        $emp_no = Auth::guard('admin')->user()->access_id;
        $status = $request->input('status');
        $statusarray= explode('-', $status);
        // $this->promotionService->addcounts();
        $result = $this->promotionService->UpdatePromo($statusarray[0],$statusarray[1], $emp_no);
        return response()->json(['data' => $result]);
    }

    public function changeTransationStatus(Request $request){

        $emp_no = Auth::guard('admin')->user()->access_id;
        $status = $request->input('status');
        $dealer_code = $request->input('dealer_code');
        $promo_code = $request->input('promo_code');
        $cancelled_date = date('Y-m-d H:i:s');
        $statusarray = explode('-', $status);
        if($statusarray[1]=='cancel'){
          $addcount = $this->dealerService->addcounts($dealer_code, $emp_no);
          $this->dealerCancelledService->Create($dealer_code, $promo_code,$cancelled_date);
        }
        $result = $this->transactionService->UpdateTransaction($statusarray[0],$statusarray[1], $emp_no);
        return response()->json(['data' => $result]);
    }
    public function transactionCreation(){

      $result['promo_code']=$this->promotionService->activePromotion();
      $result['regional_manager']=$this->regionalManager->rmNames();
      $result['dealer_master']=$this->dealerService->getDealers();

      return view('Admin.promotion_transaction',$result);
    }

    public function promotionTransaction(){
      
      $result['transactions']=$this->transactionService->allTransactions();

      return view('Admin.transaction',$result);
    }

    public function transactionPreview($id){

      $order_id = Crypt::decrypt($id);
      $transaction = $this->transactionService->getTransactionDetails($order_id);
      $result['focproduct'] = $transaction->where('product_type','FOC')->values();
      $result['offerproduct'] = $transaction->where('product_type','Offer Product')->values();
      $result['status'] = ['open','cancel']; //,'block'
      return view('Admin.transaction_view',$result);

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
          return $promo->model_no == $data_array[0]['model_no'] || $promo->product_type == 'FOC';
        });

        }
      
        $result["total_price"] =  $filteredPromos->sum('price');
        
      }elseif($comboofferflag==1 && count($data_array)>1){

        $filteredPromos = $promodata->filter(function ($promo) use ($data_array, $multiplesof) {
          $promo->qty = $promo->qty*$multiplesof;
          $promo->price= $promo->qty*$promo->price;
          return true;
        });

        $result["total_price"] =  $filteredPromos->sum('price');

      }else{
        $result["total_price"] =  "invalid input";
      }

      return response()->json($result);
    }
    
      public function transactionCreate(Request $request){
        $promocode = $request->promo_code;
        $rm_name = $request->rm_name; 
        $dealer_code = $request->dealer_code ?explode("-", $request->dealer_code) : [];
        $model = $request->model;
        $qty = $request->qty;
        $offerqty = $request->offerqty;
        $offertype=$request->offertype;
        $model_offer_qty=array_intersect_key(  $offerqty, $qty); 
        $model_qty=array_intersect_key($model, $qty);
        $model_offer_qty_array=array_combine($model_qty, $model_offer_qty);
        $model_qty_array=array_combine($model_qty, $qty);
      
        $order_id = $this->transactionService->order_id();
        
        $qtytomultiply = array_map(function($key) use ($model_offer_qty_array, $model_qty_array) {
              return $model_qty_array[$key] / $model_offer_qty_array[$key];
          },
          array_keys(array_intersect_key($model_qty_array, $model_offer_qty_array)));

          // $qtytomultiply = array_unique($qtytomultiply);
          $qtytomultiply = array_filter($qtytomultiply);
          $qtytomultiply = array_unique($qtytomultiply);
          $qtytomultiply = implode(" ",   $qtytomultiply);
          
        $promodata = $this->promotionService->getPromoDeatils($promocode);
        $producttype=$request->product_type;

        $offer=array_filter($offertype, function($value) {
          return $value !== "null";
        });
        $offer = array_unique($offer);
        $offer_type=implode(" ",  $offer);
        
        $combinedata = [];

        foreach ( $model as $key => $m) {
            $combinedata[] = [
                'model_no' => $model[$key],
                'product_type' => $producttype[$key],
                'offer_type'=> $offertype[$key],
                'qty'=>$qty[$key] ?? null,
                'offer_qty'=>$offerqty[$key],
            ];
        }

        $filteredbyoffer= $this->filter_data_by_offer_type($offer_type, $combinedata);
        $filteredbyoffer = array_values( $filteredbyoffer);
      
        if($offer_type=="Buy One Of The Product" && count($filteredbyoffer) != 1 || $filteredbyoffer[0]["qty"] % $filteredbyoffer[0]["offer_qty"] !=0){
          return 'You can only buy one of the product or product should be multiple of offer quantity';
        }else if($offer_type=="Combo Offer" && count($filteredbyoffer) > 1 || $filteredbyoffer[0]["qty"] % $filteredbyoffer[0]["offer_qty"] !=0){
          return 'Combo Offer should have atleast 2 products  or product should be multiple of offer quantity';
        }
      
        try {
              $mapped = $promodata->map(function($value) use ($offer_type,$combinedata, $qtytomultiply,$rm_name,$dealer_code,$order_id,$filteredbyoffer) {

                  $singlemodel = $this->filter_data_by_model($combinedata, $value->model_no);
                  $userInputQty = $singlemodel[0]["offer_qty"] * $qtytomultiply;
                
                  if(($offer_type== "Buy One Of The Product" && $filteredbyoffer[0]["model_no"]==$value->model_no ||$value->product_type=="FOC") || $offer_type== "Combo Offer") {
                    if ( $value->stock < $userInputQty) {
                      throw new \Exception('Stock not available for model: ' . $value->model_no);
                  }

                  if (!Carbon::parse(Carbon::now())->between( $value->from_date, $value->to_date)) {
                    throw new \Exception('Promotion has been ended: ' . $value->model_no);
                  }

                  
                  if ($value->status=="closed") {
                    throw new \Exception('Promotion has been closed: ' . $value->model_no);
                  }
                  // $formattedDate = Carbon::now()->format('Y-m-d H:i:s');

                  $value->from_date;
                  $value->to_date;
                  $value->price_type;
                  $value->offer_type;
                  $value->mrp;
                  $value->dlp;
                  $value->stock;
                  $value->order_qty = $userInputQty;
                  $value->offer_qty = $value->qty;
                  $value->transaction_slug = $this->transactionService->transaction_slug();
                  $value->rm_name= $rm_name;
                  $value->dealer_code = $dealer_code[0].'-'.$dealer_code[1];
                  $value->dealer_name= $dealer_code[2];
                  $value->order_id = $order_id ;
                  $value->ordered_by = Auth::guard('admin')->user()->access_id;
                  $value->status= "open";
                  $value->modified_by = "none";
                  $value->offer_price =  $value->price;
                  $value->order_price =  $value->price * $userInputQty;
                  $value->order_date = date('Y-m-d H:i:s');
                  // $value->created_at =  Carbon::parse($formattedDate)->format('Y-m-d H:i:s');
                  // $value->updated_at = $formattedDate;
                  unset($value->qty,$value->price,$value->total_reserved,$value->total_stock,$value->total_reserved,$value->model_desc,$value->total_order_qty);      
                  return collect($value)->except('reserved_stock');
                  }
              
                  
              })->filter()->toArray();
          
            } catch (\Exception $e) {
                return $e->getMessage();
          }


          $this->transactionService->createOrUpdateTransac($mapped);
          
          return redirect('admin/promotions/promotion-transaction');

      }

      public function promomail($id){
        
      $cryptpromo = $id;
      $promo_code = Crypt::decrypt($id);
      $promotion = $this->promotionService->getPromoDeatilsWithStock($promo_code);
      $details['focproduct'] = $promotion->where('product_type','FOC')->values();
      $details['offerproduct'] = $promotion->where('product_type','Offer Product')->values();
      $details['textfromatmodelqty'] = $this->textFormatModelQty( $details['offerproduct']->toArray(),$details['focproduct']->toArray());
      $details['email'] = 'lobojeanz@gmail.com';
      
      try {
        $promojob = PromoJob::dispatch($details);
      } catch (\Exception $e) {
        Log::error($e->getMessage());

        return redirect()->route('admin.promotions.promotion-preview',['promocode' => $cryptpromo])->with('message', 'Failed to send promo mail. Please try again.');
      }

       return redirect()->route('admin.promotions.promotion-preview',['promocode' => $cryptpromo])->with('message', 'Mail Send Successfully!!');

      }

      public function transactionmail($id){

      $crypttransaction = $id;
      $order_id = Crypt::decrypt($id);
      $transaction = $this->transactionService->getTransactionDetails($order_id);
      $details['focproduct'] = $transaction->where('product_type','FOC')->values();
      $details['offerproduct'] = $transaction->where('product_type','Offer Product')->values();
      $details['email'] = 'lobojeanz@gmail.com';

      try {
        $promojob = PromoJob::dispatch($details);
      } catch (\Exception $e) {
        Log::error($e->getMessage());

        return redirect()->route('promotions.transaction-preview',['orderid' => $crypttransaction])->with('message', 'Failed to send promo mail. Please try again.');
      }

       return redirect()->route('promotions.transaction-preview',['orderid' =>   $crypttransaction])->with('message', 'Mail Send Successfully!!');

      }  

      public function filter_data_by_offer_type($offer_type,$data){

        $filtereddata = array_filter($data, function($offer) use ($offer_type){
            return $offer["offer_type"] == $offer_type && !is_null($offer['qty']);
        });

        return $filtereddata;
      }

      public function filter_data_by_model($data,$model){

        $filtereddata = array_reduce($data, function ($carry, $item) use($model) {
          if ($item['model_no']==$model) {
              $carry[] = $item;
          }
          return $carry;
          }, []);
      
        return $filtereddata;
      }

      public function textFormatModelQty($buyItems,$freeItems){

        $and_or = isset($buyItems[0]["offer_type"]) && $buyItems[0]["offer_type"] == "Buy One Of The Product" ? ' or ' : ' and ';

        $and = ' and '; 

        $formatItems = fn($items, $suffix,$and_or) => implode($and_or, array_map(
            fn($item) => "{$item['qty']} {$suffix} {$item['model_no']}",
            $items
        ));

        $finalString = "Buy " . $formatItems($buyItems, "No(s) of",$and_or) . ", Get " . $formatItems($freeItems, "set(s) of",$and) . " FREE";

        return $finalString;
      
    }

}
