<?php

namespace App\Http\Controllers;
use App\Team;
use App\User;
use App\TeamMember;
use App\Role;
use App\UserRoleRelation;
use Illuminate\Http\Request;


class UserController extends Controller
{ 
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users'  
        ]);

        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|unique:users'  
        ]);
        $user = User::findOrFail($id);

        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete($id)
    {
            $user = User::find($id);

            if($user){
                $user->delete();
                return response()->json(array("message"=>"Deleted Successfully"), 200);
            }else{
                return response()->json(array("message"=>"User doesn't exist"), 200);
            }
    }

    public function showAllUsers()
    {
        return response()->json(User::all(),200);
    }

    public function assignUserToTeams($id, Request $request)
    {
        $this->validate($request, [
            'teams' => 'required'
        ]);

        $user_id  = $id;

        $user   = User::find($user_id);
        if(empty($user)){
            return response()->json(array("message"=>"User doesn't exist"), 200); 
        }


        $teamsArr = explode(",", $request->input('teams'));
       
        $msgArr   = array();
        foreach ($teamsArr as $key => $team_id) {
           
            if( $this->isAlreadyMember($team_id, $user_id) ){
                $msgArr[]= "User already member of Team ID: $team_id";
                continue;
            }

            $team   = Team::find($team_id);
            if( empty($team) ){
                $msgArr[]= "Team ID: $team_id doesn't exist.";
                continue;
            }

            $requestData = array();
            $requestData['user_id'] = $user_id;
            $requestData['team_id'] = $team_id; 
            $member = TeamMember::create($requestData);
            $msgArr[]= "User has been assined to Team ID: $team_id";
        } 

        return response()->json(array("message"=>$msgArr), 200);     
   
    }
   

    public function isAlreadyMember($team_id, $user_id)
    {
       
        $member   = TeamMember::where([
                                    ['team_id','=',$team_id],
                                    ['user_id','=',$user_id]
                              ])->get()->first();

        if(empty($member)){
            return false;
        }else{
            return true;
        }
    }

    public function getUserTeams($id, Request $request)
    {

        $teams = User::select('users.id','users.name','teams.title')
            ->where('users.id','=',$id)
            ->join('team_members',function($join) {
                  $join->on('team_members.user_id', '=','users.id');
                
            })
            ->join('teams',function($join) {
                 
                  $join->on('team_members.team_id', '=','teams.id');
                 
            })->get();
        
        return response()->json($teams,200);
    }

    public function assignRole($id, Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required',
        ]);

        $user_id  = $id;
        $role_id  = $request->input('role_id');

        if( $this->hasRole($role_id, $user_id) ){
            return response()->json(array("message"=>"User already has this role."), 200); 
        }

        $user   = User::find($user_id);
        
        
        if(empty($user)){
            return response()->json(array("message"=>"User doesn't exist"), 200); 
        } 

        $role   = Role::find($role_id);
        if(empty($role)){
            return response()->json(array("message"=>"Role doesn't exist"), 200); 
        }

        $requestData = array();
        $requestData['user_id'] = $user_id;
        $requestData['role_id'] = $role_id; 
        $member = UserRoleRelation::create($requestData);

        return response()->json(array("message"=>"Role has been assined to user"), 200);     
   
    }

    public function hasRole($role_id, $user_id)
    {
       
        $role   = UserRoleRelation::where([
                                    ['role_id','=',$role_id],
                                    ['user_id','=',$user_id]
                              ])->get()->first();
      
        
        if(empty($role)){
            return false;
        }else{
            return true;
        }
    }
}
