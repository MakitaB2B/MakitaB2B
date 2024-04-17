<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TeamService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Auth;

class TeamController extends Controller
{
    protected $teamService;
    public function __construct(TeamService $teamService){
        $this->teamService=$teamService;
    }
    public function index(){
        $teams=$this->teamService->getAllTeamsWithOwner();
        return view('Admin.teams',['teamList'=>$teams]);
    }
    public function createOrUpdateTeams(Request $request){
        $decripedSlug= Crypt::decrypt($request->teamSlug);
        if($decripedSlug>0){
            $rowData=$this->teamService->findTeamBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $slug=$rowData[0]->team_slug;
        }else{
            $id=0;
            $slug=Str::slug($request->name.rand());
        }
        $data= $request->validate([
             'name'=>'required|min:2|max:250',
        ]);

         if($data){
            $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug ;
            $createUpdateAction=$this->teamService->createOrUpdateTeams($id,$request,$slug,$dataOparateEmpSlug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Team sucessfully updated';
                 }
                 else{
                    $msg='Team sucessfully inserted';
                 }
                $msg='Team sucessfully inserted';
                $request->session()->flash('message',$msg);
                return redirect('admin/teams');
            }
         }
     }
     public function manageTeamMember($teamSlug){
        $result['teamMembersByTeam']=$this->teamService->teamMembersByTeam(Crypt::decrypt($teamSlug));
        $result['allEmp']=$this->teamService->fetchAllActiveEmployee();
        $result['teamslug']=$teamSlug;
        return view('Admin.manage_team_member',$result);
     }
     public function manageTeamMemberProcess(Request $request){
        $data = $request->validate([
            'teammember'=>'required|array',
        ]);
        if($data){
            $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug ;
            $teamSlug=Crypt::decrypt($request->input('teamSlug'));
            $createUpdateAction=$this->teamService->createOrUpdateTeamMembers($request,$dataOparateEmpSlug,$teamSlug);
            if($createUpdateAction){
                $msg='Teams operation sucessfully executed';
                $request->session()->flash('message',$msg);
                return redirect('admin/teams');
            }
         }
    }
}
