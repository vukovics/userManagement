<?php

namespace App\Http\Controllers\V1;

use App\Groups;
use App\Roles;
use App\User;
use App\UserGroups;
use App\UserPublicInfos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\AuthUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    use AuthUser;


    public function show()
    {

        $userData = User::all();

        return response()->json($userData);

    }

    public function getUserById($id)
    {

        $user = User::where('id', $id)->get();

        return response()->json($user);

    }


    public function delete($id, Request $request)
    {

        User::where('id', $id)->delete();

        return response()->json(User::all());

    }


    public function update($id, Request $request)
    {

        $user = User::findOrfail($id);

        if ($request->get('password') === '') {
            $request['password'] = $user->password;
        } else {
            $user->password = bcrypt($request->get('password'));
        }

        $user->update($request->all());

        return response()->json($user);

    }

    public function addUserToGroup(Request $request)
    {

        $user = UserGroups::where('user_id', '=', $request['user_id'])->where('group_id', '=', $request['group_id'])->get();

        if(count($user) >= 1){
           return $this->response->error('User already exist in group.', 409);
        }

        try {
            UserGroups::create($request->all());
        } catch (QueryException $exception) {
            return $this->response->error('User already exist in group.', 409);
        }

        return response()->json(
            [
                'success' => true,
                'userId' => $request['user_id']
            ]
        );

    }

    public function deleteUserFromGroup(Request $request)
    {

        try {
            UserGroups::where('user_id','=', $request['userId'])->where('group_id','=', $request['id'])->delete();
        } catch (QueryException $exception) {
            return $this->response->error('User dont exist.', 409);
        }

        return response()->json(
            [
                'success' => true,
                'userId' => $request['userId']
            ]
        );

    }

    public function create(Request $request){

        try{

            $input = $request->all();

            //Hash password
            $input['password'] =  Hash::make($input['password']);

            $input['code'] = str_random(50);

            User::create($input);

        }catch (QueryException $exception){

            return $this->response->error('User already exist.', 409);
        }

        return $this->response->created();

    }

    public function getUserGroups($id){

       $userGroups =  Groups::select('groups.id','groups.group_name', 'users.id as userId')
            ->join('user_groups', 'user_groups.group_id', '=', 'groups.id')
            ->join('users', 'user_groups.user_id', '=', 'users.id')
            ->where('users.id','=', $id)
            ->get();

        $allGorups =  Groups::select(DB::raw('count(user_groups.user_id) as user_count, groups.id, groups.group_name'))
            ->leftjoin('user_groups', 'user_groups.group_id', '=', 'groups.id')
            ->groupBy('groups.id')
            ->get();


        return response()->json(
            [
                'userGroups' => $userGroups,
                'groups'=> $allGorups,
                'success' => true,
            ]
        );

    }


}
