<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\HolidayService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class HolidayController extends Controller
{
    protected $holidayService;
    public function __construct(HolidayService $holidayService){
        $this->holidayService=$holidayService;
    }
    public function index(){
        $holidays=$this->holidayService->getAllHolidays();
        return view('Admin.holidays',['holidayList'=>$holidays]);
    }
    public function manageHoliday(Request $request,$slug=''){
        $holidayTypes=$this->holidayService->fetchAllHolidayTypes();
        $states=$this->holidayService->fetchAllStates();
        if($slug>0){
            $decSlug=Crypt::decrypt($slug);
            $arr=$this->holidayService->findBySlug($decSlug);
            $result['name']=$arr[0]->name;
            $result['notes']=$arr[0]->notes;
            $result['from_date']=date('Y-m-d',strtotime($arr[0]->from_date));
            $result['to_date']=date('Y-m-d',strtotime($arr[0]->to_date));
            $result['type']=$arr[0]->type;
            $result['state']=$arr[0]->state;
            $result['slug']=Crypt::encrypt($arr[0]->slug);
            $result['holiday_types']=$holidayTypes;
        }else{
            $result['name']='';
            $result['notes']='';
            $result['from_date']='';
            $result['to_date']='';
            $result['type']='';
            $result['state']='';
            $result['slug']=Crypt::encrypt(0);
            $result['holiday_types']=$holidayTypes;
        }
        $result['states']=$states;
        return view('Admin.manage_holidays',$result);
    }
    public function createOrUpdateHolidayController(Request $request){
        $decripedSlug= Crypt::decrypt($request->slug);
        if($decripedSlug>0){
            $rowData=$this->holidayService->findBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $slug=$rowData[0]->slug;
        }else{
            $id=0;
            $slug=Str::slug($request->name.rand());
        }
        $data= $request->validate([
             'name'=>'required|min:2|max:250',
             'holiday_notes'=>'min:2',
             'from_date'=>'required',
             'to_date'=>'required',
             'holidaytype'=>'required',
         ]);

         if($data){
            $createUpdateAction=$this->holidayService->createOrUpdateHoliday($id,$request,$slug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Holiday sucessfully updated';
                 }
                 else{
                    $msg='Holiday sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/holidays');
            }
         }
     }
}
