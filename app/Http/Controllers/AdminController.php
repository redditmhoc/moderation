<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function managePermissions()
    {
        $users = User::all();
        $roles = Role::all();

        return view('admin.managepermissions', compact('users', 'roles'));
    }

    public function assignRoleAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Please fill all fields.'], 400);
        }

        $user = User::where('username',$request->get('user'))->first();

        if($user) {
            if($user->hasRole($request->get('role'))) {
                return response()->json(['message' => 'This user already has this role.'], 400);
            }
            $user->assignRole($request->get('role'));
            $user->save();
        } else {
            return response()->json(['message' => 'User doesn\'t exist.'], 400);
        }

        return response()->json(['message' => 'Assigned!'], 200);
    }

    public function removeRoleAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Not all fields defined'], 400);
        }

        $user = User::where('username',$request->get('user'))->first();

        if($user) {
            if(!$user->hasRole($request->get('role'))) {
                return response()->json(['message' => 'This user doesn\'t have this role.'], 400);
            }
            $user->removeRole($request->get('role'));
            $user->save();
        } else {
            return response()->json(['message' => 'User doesn\'t exist.'], 400);
        }

        return response()->json(['message' => 'Removed!'], 200);
    }

    public function searchUserInfoAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Please select a user'], 400);
        }

        $user = User::where('username',$request->get('user'))->first();

        if($user) {
            return response()->json(['user' => $user, 'roles' => $user->roles, 'permissions' => $user->permissions], 200);
        } else {
            return response()->json(['message' => 'User doesn\'t exist.'], 400);
        }
    }
}
