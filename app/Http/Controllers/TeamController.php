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
            return response()->json(array("message"=>"Owner doesn't exist in User table."), 204);
        }
   
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        $team = Team::findOrFail($id);

        $team->update($request->all());

        return response()->json($team, 200);
    }

    public function delete($id)
    {
            $team = Team::find($id);

            if($team){
                $team->delete();
                return response()->json(array("message"=>"Deleted Successfully"), 200);
            }else{
                return response()->json(array("message"=>"Team doesn't exist"), 204);
            }
    }

    public function showAllTeams()
    {
        return response()->json(Team::all(),200);
    }
    

    
}
