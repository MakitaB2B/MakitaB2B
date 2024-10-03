<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TravelManagementService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;

class TravelManagementController extends Controller
{
    protected $travelManagementService;
    public function __construct(TravelManagementService $travelManagementService){
        $this->travelManagementService=$travelManagementService;
    }
    public function createTravelMangmentApplication(Request $request){

        echo $request->vechile_type;
        echo '<br>';
        echo $request->vechile_number;
        echo '<br>';
        echo $request->fuel_expenses;
        echo '<br>';
        print_r($request->groupbt_employees);

        die();

        $applicantSlug=Auth::guard('admin')->user()->employee_slug;
        $btaSlug=Str::slug(rand().rand());
        $travelID='bta'.rand();
        $status=0;

        $createUpdateAction=$this->travelManagementService->createBTAApplication($request,$btaSlug,$applicantSlug,$travelID,$status);

        if($createUpdateAction){
            $msg='Yes! You Have Sucessfully Applied for BTA';
            $request->session()->flash('message',$msg);
            return redirect('admin/travelmanagement/applyviewclaimtravelexpenses');
        }else{
            $msg='Error! BTA Application Not Executed';
            $request->session()->flash('message',$msg);
            return redirect('admin/travelmanagement/applyviewclaimtravelexpenses');
        }

     }

}
