<?php

namespace App\Http\Controllers\V1;

use App\Groups;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\AuthUser;
use App\UserGroups;

class GroupController extends Controller
{
    use AuthUser;


    public function show()
    {

        $groups = Groups::all();

        return response()->json($groups);

    }

    public function create(Request $request){

        try{

            $input = $request->all();

            Groups::create($input);

        }catch (QueryException $exception){

            return $this->response->error('Group already exist.', 409);
        }

        return $this->response->created();

    }



    public function delete(Request $request)
    {

        $allUsersFromOneGroup = UserGroups::where('group_id', '=', $request['group_id'])->get();

        if (count($allUsersFromOneGroup) >= 1) {
            return response()->json([
                'success' => false,
                'result' => 'Group is not empty'
            ]);
        }

        Groups::where('id', $request['id'])->delete();

        return response()->json(Groups::all());

    }


    public function update($id, Request $request)
    {

        $group = Groups::findOrfail($id);

        $group->update($request->all());

        return response()->json($group);

    }
}
