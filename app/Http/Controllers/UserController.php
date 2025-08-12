<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $nav_title = "Users List";
        return view('superadmin.users.list', compact('users','nav_title'));
    }

    public function usersAjax(Request $request)
{
    $users = User::query();

    return DataTables::of($users)
        ->addIndexColumn()
        ->addColumn('role', function ($user) {
            $roles = [
                0 => 'Super Admin',
                1 => 'Director General',
                2 => 'Director Lands',
                3 => 'Director Admin',
                4 => 'Duty Officer',
                5 => 'Duty Clerk',
                6 => 'Duty Wo',
                7 => 'Duty Driver',
                8 => 'Duty Radio',
            ];
            return $roles[$user->is_role] ?? 'Unknown';
        })
        ->addColumn('action', function ($user) {
            $edit = route('superadmin.users.edit', $user->id);
            $delete = route('superadmin.users.destroy', $user->id);

            return '
                <a href="' . $edit . '" class="btn btn-sm btn-primary">Edit</a>
                <form action="' . $delete . '" method="POST" style="display:inline-block;">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button class="btn btn-sm btn-danger" id="delete")">Delete</button>
                </form>';
        })
        ->rawColumns(['action'])
        ->make(true);
}
    // ✅ Show create user form
    public function create()
    {
        $nav_title = "Add Users";
        return view('superadmin.users.add', compact('nav_title'));
    }

    // ✅ Store new user
    public function store(Request $request)
{
    $request->validate([
        'service_no'       => 'required|string|unique:users',
        'rank'             => 'required|string|max:50',
        'fname'            => 'required|string|max:255',
        'unit'             => 'required|string|max:255',
        'arm_of_service'   => 'nullable|in:ARMY,NAVY,AIRFORCE',
        'gender'           => 'nullable|in:Male,Female',
        'email'            => 'required|email|unique:users',
        'phone'            => 'nullable|string|max:20',
        'is_role'          => 'required|integer',
        // Removed password validation here
    ]);

    User::create([
        'service_no'       => trim($request->service_no),
        'rank'             => trim($request->rank),
        'fname'            => trim($request->fname),
        'unit'             => trim($request->unit),
        'arm_of_service'   => $request->arm_of_service,
        'gender'           => $request->gender,
        'email'            => trim($request->email),
        'phone'            => trim($request->phone),
        'password'         => Hash::make('123456'),  // default password
        'is_role'          => $request->is_role,
        'remember_token'   => Str::random(50),
    ]);

    return redirect()->route('superadmin.users.list')->with([
        'message' => 'User created successfully with default password',
        'alert-type' => 'success'
    ]);
}


    // ✅ Show edit form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $nav_title = "Edit Users";
        return view('superadmin.users.edit', compact('user','nav_title'));
    }

    // ✅ Update user
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'service_no'       => 'required|string|unique:users,service_no,' . $user->id,
        'rank'             => 'required|string|max:50',
        'fname'            => 'required|string|max:255',
        'unit'             => 'required|string|max:255',
        'arm_of_service'   => 'nullable|in:ARMY,NAVY,AIRFORCE',
        'gender'           => 'nullable|in:Male,Female',
        'email'            => 'required|email|unique:users,email,' . $user->id,
        'phone'            => 'nullable|string|max:20',
        'password'         => 'nullable|min:6|confirmed',
        'is_role'          => 'required|integer',
    ]);

    $user->update([
        'service_no'       => trim($request->service_no),
        'rank'             => trim($request->rank),
        'fname'            => trim($request->fname),
        'unit'             => trim($request->unit),
        'arm_of_service'   => $request->arm_of_service,
        'gender'           => $request->gender,
        'email'            => trim($request->email),
        'phone'            => trim($request->phone),
        'is_role'          => $request->is_role,
    ]);

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
        $user->save(); // Save again if password is updated
    }

    return redirect()->route('superadmin.users.list')->with([
        'message' => 'User updated successfully',
        'alert-type' => 'success'
    ]);
}

    // ✅ Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('superadmin.users.list')->with([
        'message' => 'User deleted successfully',
        'alert-type' => 'success'
    ]);
    }
}
