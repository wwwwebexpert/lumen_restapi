<?php

namespace App\Http\Controllers;
use App\User;
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
                return response('Deleted Successfully', 200); 
            }else{
                return response('User doesn\'t exist.', 200);
            }
    }

    public function showAllUsers()
    {
        return response()->json(User::all());
    }
}
