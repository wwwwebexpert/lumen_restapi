<?php

namespace App\Http\Controllers;
use App\Team;
use App\User;
use App\TeamMember;
use Illuminate\Http\Request;

class TeamController extends Controller
{ 
    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $team = Team::create($request->all());

        return response()->json($team, 201);
    }


    public function assignOwner($id, Request $request)
    {
        $this->validate($request, [
            'owner' => 'required',
        ]);

        $owner = $request->input('owner');
        $user  = User::find($owner);
        
        if($user){
            $team = Team::find($id);
            $team->update($request->all());
            return response()->json($team, 200);
        }else{
            return response('Owner doesn\'t exist in User table.', 202);
        }
   
    }

    public function assignUsersToTeam($id, Request $request)
    {
        $this->validate($request, [
            'user' => 'required',
        ]);

        $user_id = $request->input('user');
        $team_id = $id;
        
        if( $this->isAlreadyMember($team_id, $user_id) ){
            return response('User already member of this team.', 202);
        }

        $team   = Team::find($team_id);
        if( empty($team) ){
            return response('Team ID doesn\'t exist.', 202);
        }

        $user   = User::find($user_id);
        if(empty($user)){
            return response('User ID doesn\'t exist.', 202);
        }

        $requestData = array();
        $requestData['user_id'] = $user_id;
        $requestData['team_id'] = $team_id; 
        $member = TeamMember::create($requestData);

        return response()->json($member, 200);     
   
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

    
}
