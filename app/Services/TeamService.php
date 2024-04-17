<?php
namespace App\Services;
use App\Models\Admin\Team;
use App\Models\Admin\TeamMembers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
class TeamService{
    public function getAllTeamsWithOwner(){
        return Team::with(['employee:employee_slug,full_name,employee_no'])->select('team_name','team_owner','team_slug')->get();
    }
    public function findTeamBySlug($slug){
        return Team::where(['team_slug'=>$slug])->get();
    }
    // public function fetchAllHolidayTypes(){
    //     return DB::table('holiday_types')->get();
    // }
    // public function fetchAllStates(){
    //     return DB::table('states')->get();
    // }
    public function createOrUpdateTeams($id,$request,$slug,$dataOparateEmpSlug){
        $operate=Team::updateOrCreate(
            ['id' =>$id],
            ['team_name'=> $request->name,'team_owner'=>$dataOparateEmpSlug,'team_slug'=>$slug]
         );
         if($operate){
            return true;
         }
    }
    public function teamMembersByTeam($teamSlug){
        return TeamMembers::where(['team_slug'=>$teamSlug])->get();
    }
    public function fetchAllActiveEmployee(){
        return DB::table('employees')->where(['status'=>1])->get(['employee_no','full_name','employee_slug']);
    }
    public function createOrUpdateTeamMembers($request,$dataOparateEmpSlug,$teamSlug){
        // Team Members
        $teamMemberCount=$request->input('teamMemberCount');
        $updateTeamMembers=$request->input('teammember');
        if($teamMemberCount>0){
        $teamMemberBM=$request->input('temamembers_befor_modify');
        if($teamMemberBM != $updateTeamMembers){
                $teamMemberArrayDiffToDelete=array_diff($teamMemberBM,$updateTeamMembers);
                $teamMemberArrayDiffToInsert=array_diff($updateTeamMembers,$teamMemberBM);

                if(count($teamMemberArrayDiffToInsert)>0){
                    foreach ($updateTeamMembers as $teamMemberData) {
                        $teamMemberRecordsInsert[] = [
                            'team_slug' => $teamSlug,
                            'team_owner' => $dataOparateEmpSlug,
                            'team_member' => Crypt::decrypt($teamMemberData),
                            'team_member_slug'=>rand(),
                        ];
                    }
                    TeamMembers::insert($teamMemberRecordsInsert);

                }
                if(count($teamMemberArrayDiffToDelete)>0){
                    foreach($teamMemberArrayDiffToDelete as $teamMemberSlugDel){
                        TeamMembers::WHERE('team_member', $teamMemberSlugDel)->WHERE('team_slug', $teamSlug)->first()->delete();
                    }
                }
            }

        }if($teamMemberCount == 0){
            foreach ($updateTeamMembers as $teamMemberData) {
                $teamMemberRecordsInsert[] = [
                    'team_slug' => $teamSlug,
                    'team_owner' => $dataOparateEmpSlug,
                    'team_member' => Crypt::decrypt($teamMemberData),
                    'team_member_slug'=>rand(),
                ];
            }
            TeamMembers::insert($teamMemberRecordsInsert);
        }
        return true;
    }

}
?>
