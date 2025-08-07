<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    public function UserView()
    {
        $users = Auth::user(); // Get the currently logged-in user
        $allUsers = User::all(); // Get all users
        $nav_title = "User List";

        // Pass both variables to the view
        return view("backend.user.view_user", compact('users', 'allUsers', 'nav_title'));
    }

    public function UserAdd()
    {
        $users = Auth::user(); // Get the currently logged-in user
        $nav_title = "Add User";

        return view("backend.user.add_user", compact('users', 'nav_title'));
    }

    public function UserStore(Request $request)
    {
        $validateData = $request->validate([
            "email" => "required|unique:users",
            "name" => "required",
        ]);

        $data = new User();
        $data->usertype = $request->usertype;
        $data->email = $request->email;
        $data->name = $request->name;
        $data->password = bcrypt($request->password);
        $data->save();


        $notification = array(
            'message' => 'User Inserted Successfully',
            'alert-type' => 'success'
        );


        return redirect()->route('users.view')->with($notification);
    }

    public function UserEdit($id)
    {
        $editData = User::find($id);
        $users = Auth::user(); // Get the currently logged-in user
        $nav_title = "Edit User";
        return view('backend.user.edit_user', compact('editData', 'users', 'nav_title'));
    }

    public function UserUpdate(Request $request, $id)
    {


        $data = User::find($id);
        $data->usertype = $request->usertype;
        $data->email = $request->email;
        $data->name = $request->name;
        $data->save();


        $notification = array(
            'message' => 'User Updated Successfully',
            'alert-type' => 'info'
        );


        return redirect()->route('users.view')->with($notification);
    }

    public function UserDelete($id)
    {
        $users = Auth::user();

        $users->delete();

        $notification = array(
            'message' => 'User Deleted Successfully',
            'alert-type' => 'info'
        );


        return redirect()->route('users.view')->with($notification);
    }
}
