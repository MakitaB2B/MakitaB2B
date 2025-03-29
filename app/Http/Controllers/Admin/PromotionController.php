<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PromotionService;
use App\Services\TransactionService;
use App\Services\EmployeeService;
use App\Services\DealerService;
use App\Services\DealerCancelledService;
use App\Services\TeamService;
use App\Services\TransactionEmailService;
use App\Models\Admin\BranchStocks;
use Auth;
use Carbon\Carbon;
use App\Models\Admin\Transaction;
use App\Models\Admin\TransactionEmail;
use Illuminate\Support\Facades\Crypt;
use App\Jobs\PromoJob;
use App\Jobs\TransactionJob;
use App\Jobs\TransactionCancelJob;


class PromotionController extends Controller
{
    protected $promotionService;
    protected $transactionService;

    public function __construct(PromotionService $promotionService,TransactionService $transactionService,EmployeeService $employeeService,DealerService $dealerService,DealerCancelledService $dealerCancelledService,TeamService $teamService,TransactionEmailService $transactionEmailService){
      $this->promotionService=$promotionService;
      $this->transactionService=$transactionService;
      $this->employeeService=$employeeService;
      $this->dealerService=$dealerService;
      $this->dealerCancelledService=$dealerCancelledService;
      $this->teamService=$teamService;
      $this->transactionEmailService=$transactionEmailService;
    }

    public function index(){

      $result['promo_list']=$this->promotionService->listPromotions();
      return view('Admin.promotion',$result); 
    }
    
    public function uploadPromotion(Request $request){

      if(request()->has('mycsv')){

        $data=array_map('str_getcsv', file(request()->mycsv));
     
        $effective_from=$data[0];

        $effective_from = array_filter($effective_from);

        $effective_from=preg_replace('/^\x{FEFF}/u', '',   $effective_from[0]);

        $date=null;
        if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $effective_from, $matches)) {
          $date = $matches[0]; 
        }

        $from_date = $date;
        $header=$data[1];
        unset($data[0], $data[1]);
        $error_promo = [];
        foreach ($data as $value) {
          set_time_limit(0);
          $promoData=array_combine($header,$value);

          $promoData = $this->split_promo_array($promoData,$from_date);

          $promo_check = $this->promotionService->ckeck_if_exists($promoData[0]['promo_code']);

          if(!$promo_check){
       
            $data = $this->promotionService->createOrUpdatePromo($promoData);
            if(!empty($data)){
              $error_promo[]=$promoData[0]['promo_code'];
            }
          }
        
        }

      }

      if(empty($error_promo)){
        return redirect('admin/promotions')->with('success', 'Promotion uploaded successfully');
      } else {
        return 'Please add there promo manually'.implode(', ', $error_promo);
      }

    }

    public function split_promo_array($array, $from_date) {
      $array = array_filter($array, fn($value, $key) => $key !== "", ARRAY_FILTER_USE_BOTH);
      $keys = array_keys($array);
      $splitIndices = array_filter(array_keys($keys), function ($index) use ($keys) {
          return str_contains($keys[$index], 'Stock');
      });
  
      $splitIndices = array_merge([-1], $splitIndices, [count($keys)]);
  
      $result = array_map(function ($start, $end) use ($keys, $array) {
          return array_slice($array, $start + 1, $end - $start, true);
      }, $splitIndices, array_slice($splitIndices, 1));
  
      // $result = array_filter($result, function ($subArray) {
      //     return array_filter(array_keys($subArray), fn($key) => str_contains($key, 'Stock'));
      // });

      $hasMainKey = !empty(array_column($result, 'Price-FOC 1'));

      $priceFoc1 = array_column($result, 'Price-FOC 1')[0];

      $offer_type = $hasMainKey && $priceFoc1 == "BEST" ? "Combo Offer" : "Buy One Of The Product";
  
      $code = $array['CODE'] ?? null;
      $valid_for = $array['Valid for'] ?? null;
      $modelKeys = ['Code-Main', 'Code-FOC 1', 'Code-FOC 2', 'Code-FOC 3'];
      $priceKeys = ['Price-Main','Price-FOC 1', 'Price-FOC 2', 'Price-FOC 3'];
      $priceTypes = ["BEST" => "Best Price", "SPECIAL" => "Special Price", "FOC" => "Special Price", "DLP" => "DLP","dlp" => "DLP"];
      $qtyTypes = ['MOQ','Qty-FOC 1','Qty-FOC 2','Qty-FOC 3','Qty-FOC 4'];
      $priceValues = ['Offer-Main','Offer-FOC 1','Offer-FOC 2','Offer-FOC 3','Offer-FOC 4'];
      $result = array_map(function ($subArray) use ($code,$valid_for,$from_date,$offer_type,$modelKeys,$priceFoc1,$priceKeys,$priceTypes,$qtyTypes,$priceValues) {
       
          $subArray['promotion_slug'] = $this->promotionService->promotion_slug();
          $subArray['promo_code'] = $code;
          $subArray['to_date'] =  \Carbon\Carbon::createFromFormat('d-m-Y', $valid_for)->format('Y-m-d'); //$valid_for; 
          $subArray['from_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $from_date)->format('Y-m-d');
        

          // $subArray['model_no'] = array_filter(array_map(function ($key) use ($subArray) {
          //   return $subArray[$key] ?? null;
          // }, $modelKeys));

          $modelNoArray = array_filter(array_map(function ($key) use ($subArray) {
            return $subArray[$key] ?? null;
          }, $modelKeys));

          $subArray['model_no'] = implode(", ", $modelNoArray); 

          $keysNoArray = array_filter(array_map(function ($key) use ($subArray) {
            return $subArray[$key] ?? null;
          }, $priceKeys));

          $qtyArray = array_filter(array_map(function ($key) use ($subArray) {
            return $subArray[$key] ?? null;
          }, $qtyTypes));

          $price = array_filter(array_map(function ($key) use ($subArray) {
            return $subArray[$key] ?? null;
          }, $priceValues));

          $price = implode(",",$price); 

          $price = str_replace(',', '', $price);

          $subArray['price_type'] = $priceTypes[implode(", ", $keysNoArray)] ?? (stripos(implode(", ", $keysNoArray), 'DLP') !== false ? "DLP" : "Unknown");

          $model_details = $this->promotionService->modeldetailSearchNonJson($modelNoArray);
          
          $subArray['price'] =  (int)$price;
          
          // ($subArray['price_type'] === 'Best Price') ? (int)$model_details->best : 
          // (($subArray['price_type'] === 'DLP' || $subArray['price_type'] === 'dlp') ? (int)$model_details->dlp : 
          // (($subArray['price_type'] === 'Special Price' || $subArray['price_type'] === 'FOC') ? (int)$price : ''));
          
          $subArray['model_desc'] = $model_details?->description ?? '';
          $subArray['mrp'] =$model_details->mrp ?? ''; 
          $subArray['dlp'] =$model_details->dlp ?? ''; 
          $subArray['stock'] = $model_details->total_stock ?? ''; 
          $subArray['qty'] = (int)implode(",", $qtyArray); 
          $subArray['status'] = "Active"; 
          $subArray['created_by'] = Auth::guard('admin')->user()->access_id;
          $subArray['created_at'] = date('Y-m-d H:i:s');
          $subArray['updated_at'] = date('Y-m-d H:i:s');
      
          if (array_key_exists('Main', $subArray)) {
            $subArray['product_type'] = 'Offer Product';
            $subArray['offer_type'] = $offer_type;
          }elseif (array_key_exists('Price-FOC 1',$subArray) && $subArray['Price-FOC 1']=="BEST"){
            $subArray['product_type'] = 'Offer Product';
            $subArray['offer_type'] = $offer_type;
          }else{
            $subArray['product_type'] = 'FOC';
            $subArray['offer_type'] = null;
          }

          return $subArray;
      }, $result);

      $result = array_filter($result, function ($subArray) {
          $codeFOCKeys = array_filter(array_keys($subArray), fn($key) => str_contains($key, 'Code-FOC') || str_contains($key, 'Code-Main'));
          foreach ($codeFOCKeys as $key) {
              if (!empty($subArray[$key])) {
                  return true;
              }
          }
          return false;
      });

      $allowedColumns = \Schema::getColumnListing('promotions');

      $result = array_map(function ($row) use ($allowedColumns) {
          return array_filter($row, function ($key) use ($allowedColumns) {
              return in_array($key, $allowedColumns);
          }, ARRAY_FILTER_USE_KEY);
      }, $result);
 
      return $result;
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
        $result = $this->transactionService->UpdateTransaction($statusarray[0],$statusarray[1], $emp_no);
        if($statusarray[1]=='cancel'){
          $addcount = $this->dealerService->addcounts($dealer_code, $emp_no);
          $this->dealerCancelledService->Create($dealer_code, $promo_code,$cancelled_date);
          $this->transactionCancelMail($statusarray[0]);
        }

        return response()->json(['data' => $result]);
    }
    public function transactionCreation(){
      // $designation='regional manager';
      // $department='sales';
      $result['promo_code']=$this->promotionService->activePromotion();
      // $result['regional_manager']= $this->employeeService->getEmployeeByDesignation($designation,$department);  //$this->regionalManager->rmNames();
      $loggedIn = Auth::guard('admin')->user()->employee_slug;
      $result['regional_manager'] = $this->teamService->getTeamOwner($loggedIn);
      if(empty($result['regional_manager'])){
       return  redirect("/admin/promotions/promotion-transaction")->with(["error"=>"You're not a team owner or a team member. Please contact your manager."]);
      }
      $result['transaction_email'] = $this->transactionEmailService->getTransactionDetails($result['regional_manager']->team_owner);
      $result['dealer_master']= $this->dealerService->getDealers();

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

      // dd($result['focproduct'],$result['offerproduct']);
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
        $region=explode("-",$request->rm_region) ?? $request->rm_region;
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
        $pricetype=$request->pricetype;

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
                'price_type' => $pricetype[$key]
            ];
        }

        $filteredbyoffer= $this->filter_data_by_offer_type($offer_type, $combinedata);
        $filteredbyoffer = array_values( $filteredbyoffer);

        if($offer_type=="Buy One Of The Product" && count($filteredbyoffer) != 1 && $filteredbyoffer[0]["price_type"] !="Special Price" || $filteredbyoffer[0]["qty"]==0 || $filteredbyoffer[0]["qty"] % $filteredbyoffer[0]["offer_qty"] !=0 && $filteredbyoffer[0]["price_type"] !="Special Price" ){
          return 'You can only buy one of the product or product should be multiple of offer quantity';
        }else if($offer_type=="Combo Offer" && (count($filteredbyoffer) > 1|| $filteredbyoffer[0]["qty"]==0 || $filteredbyoffer[0]["qty"] % $filteredbyoffer[0]["offer_qty"] !=0)){
          return 'Combo Offer should have atleast 2 products  or product should be multiple of offer quantity';
        }
          
        try {
              $mapped = $promodata->map(function($value) use ($region,$offer_type,$combinedata, $qtytomultiply,$rm_name,$dealer_code,$order_id,$filteredbyoffer) {

                  $singlemodel = $this->filter_data_by_model($combinedata, $value->model_no , $value->product_type,$value->price_type,$value->offer_type);

                  $userInputQty = ($value->offer_type === "Buy One Of The Product" && $value->price_type === "Special Price" && $value->product_type === "Offer Product") ? $singlemodel[0]["qty"] : $value->qty * (int)floor($qtytomultiply);
                
                  if(($offer_type== "Buy One Of The Product" && $filteredbyoffer[0]["model_no"]==$value->model_no ||$value->product_type=="FOC") || $offer_type== "Combo Offer") {
                    if ( $value->stock < $userInputQty) {
                      throw new \Exception('Stock not available for model: ' . $value->model_no);
                  }

                  if (!Carbon::parse(Carbon::now())->between( $value->from_date, date('Y-m-d', strtotime($value->to_date. ' +1 day')))) {
                    throw new \Exception('Promotion has been ended: ' . $value->model_no);
                  }

                  if ($value->status=="closed") {
                    throw new \Exception('Promotion has been closed: ' . $value->model_no);
                  }

                  if($value->price_type =="Best Price" && (int)$value->best!= (int)$value->price || $value->price_type =="DLP" && (int)$value->dlp!=(int)$value->price ){
                    throw new \Exception('<h3>Promo price do not match with item prices . Please <b>contact HO - Sales Co-ordinator / Ms.Agila </b> for more information. For Promo Code -' . $value->promo_code.'<h3>'); 
                  }

                  // $formattedDate = Carbon::now()->format('Y-m-d H:i:s');
                  $value->from_date;
                  $value->to_date;
                  $value->price_type;
                  $value->offer_type;
                  $value->mrp;
                  $value->dlp;
                  $value->stock;
                  $value->order_qty = (int)$userInputQty;
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
                  $value->region=$region[0];
                  $value->sales_slug=$region[1];
                  // $value->created_at =  Carbon::parse($formattedDate)->format('Y-m-d H:i:s');
                  // $value->updated_at = $formattedDate;
                  unset($value->best,$value->lp,$value->qty,$value->price,$value->total_reserved,$value->total_stock,$value->total_reserved,$value->model_desc,$value->total_order_qty);      
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
      $details['email'] = PROMO_TO;
      $details['cc'] = PROMO_CC;
      $details['bcc'] =PROMO_BCC;
      try {
        $promojob = PromoJob::dispatch($details);
      } catch (\Exception $e) {
        Log::error($e->getMessage());

        // return redirect()->route('admin.promotions.promotion-preview',['promocode' => $cryptpromo])->with('message', 'Failed to send promo mail. Please try again.');
      return response()->json(['message' => $e->getMessage()]);
      }

      //  return redirect()->route('admin.promotions.promotion-preview',['promocode' => $cryptpromo])->with('message', 'Mail Send Successfully!!');
      return response()->json(['message' => "Promotion Mail Sent Successfully!"]);
      }

      public function transactionmail($id){
      $crypttransaction = $id;
      $order_id = Crypt::decrypt($id);
      $transaction = $this->transactionService->getTransactionDetails($order_id);
      $details['focproduct'] = $transaction->where('product_type','FOC')->values();
      $details['offerproduct'] = $transaction->where('product_type','Offer Product')->values();
      // $details['offerproductStock'] =  $this->transactionService->getTransactionWithStock($details['offerproduct'][0]["model_no"],$order_id);
      $details['email'] = PROMO_TRANSACTION_TO_EMAILS;
      $details['bcc'] =PROMO_TRANSACTION_BCC;
      $sales_mail=$this->transactionEmailService->getEmailId($transaction[0]['sales_slug']);
      $rm_name=$this->employeeService->getOfficialMailByName($transaction[0]['rm_name']);
      $createdby=$this->employeeService->findEmployeeEmailByEmpNo( $transaction[0]['ordered_by']);
      $promo_transaction_cc_emails = PROMO_TRANSACTION_CC_EMAILS;
      $additionalEmails = array_filter([$sales_mail, $rm_name, $createdby]);
      $promo_transaction_cc_emails = array_merge(array_keys($promo_transaction_cc_emails), $additionalEmails);
      $promo_transaction_cc_emails = array_unique($promo_transaction_cc_emails);
      $details['cc'] = $promo_transaction_cc_emails;  
      try {
        $transactionjob = TransactionJob::dispatch($details);
      } catch (\Exception $e) {

        Log::error($e->getMessage());

        // return redirect()->route('promotions.transaction-preview',['orderid' => $crypttransaction])->with('message', 'Failed to send promo mail. Please try again.');
        return response()->json(['message' => $e->getMessage()]);
      }

      //  return redirect()->route('promotions.transaction-preview',['orderid' =>   $crypttransaction])->with('message', 'Mail Send Successfully!!');
      return response()->json(['message' => "Transaction Mail Sent Successfully!"]);
      }  


      public function transactionCancelMail($order_id){
        $transaction = $this->transactionService->getTransactionDetails($order_id);

        $details['focproduct'] = $transaction->where('product_type','FOC')->values();
        $details['offerproduct'] = $transaction->where('product_type','Offer Product')->values();

        $details['email'] = PROMO_TRANSACTION_TO_EMAILS;
        $details['bcc'] =PROMO_TRANSACTION_BCC;
        $sales_mail=$this->transactionEmailService->getEmailId($transaction[0]['sales_slug']);
        $rm_name=$this->employeeService->getOfficialMailByName($transaction[0]['rm_name']);
        $promo_transaction_cc_emails = PROMO_TRANSACTION_CC_EMAILS;
        // array_push($promo_transaction_cc_emails,$sales_mail, $rm_name);
        $details['cc'] = $promo_transaction_cc_emails;
        $details['canceledby']=$this->employeeService->findEmployeeByEmpNo( $transaction[0]['modified_by']);
      
        try {
          $transactioncanceljob = TransactionCancelJob::dispatch($details);
        } catch (\Exception $e) {
  
          Log::error($e->getMessage());
  
          return response()->json(['message' => $e->getMessage()]);
        }
  
        return response()->json(['message' => "Transaction Cancel Mail Sent Successfully!"]);

      }

      public function filter_data_by_offer_type($offer_type,$data){

        $filtereddata = array_filter($data, function($offer) use ($offer_type){
            return $offer["offer_type"] == $offer_type && !is_null($offer['qty']);
        });

        return $filtereddata;
      }

      public function filter_data_by_model($data,$model,$product_type,$price_type,$offer_type){

        $filtereddata = array_reduce($data, function ($carry, $item) use($model,$product_type,$price_type,$offer_type) {
          if ($item['model_no']==$model && $item['product_type'] == $product_type && $item['price_type'] == $price_type && $item['offer_type'] ==$offer_type) {
              $carry[] = $item;
          }
          return $carry;
          }, []);
      
        return $filtereddata;
      }

      public function textFormatModelQty($buyItems,$freeItems){

        $and_or = isset($buyItems[0]["offer_type"]) && $buyItems[0]["offer_type"] == "Buy One Of The Product" ? ' or ' : ' and ';

        $and = ' and '; 

        // $formatItems = fn($items, $suffix,$and_or) => implode($and_or, array_map(
        //     fn($item) => "{$item['qty']} {$suffix} {$item['model_no']}",
        //     $items
        // ));

        $formatItems = fn($items, $suffix, $and_or) => implode($and_or, array_map(
          fn($item) => "{$item['qty']} {$suffix} {$item['model_no']}" .
                       (($item['product_type'] === 'FOC') 
                          ? (($item['price'] != 0) ? " at Special Price" : " FREE") 
                          : ""),
          $items
      ));
     
        // $finalString = "Buy " . $formatItems($buyItems, "No(s) of",$and_or) . ", Get " . $formatItems($freeItems, "set(s) of",$and) . " FREE";

        // return $finalString;

        $buyText = $formatItems($buyItems, "No(s) of", $and_or);
        $freeText = $formatItems($freeItems, "set(s) of", $and);

    
        $finalString = "Buy $buyText";
    
        if (!empty($freeText)) {
            $finalString .= ", Get $freeText";
        }
    
        return $finalString;
      
      }

}
