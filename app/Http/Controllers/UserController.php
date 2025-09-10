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

    public function ajax(Request $request)
{
    $users = User::with(['unit', 'rank'])->select('users.*'); // Don't list specific columns

    return DataTables::of($users)
        ->addIndexColumn()
        ->editColumn('rank', function ($user) {
            return $user->display_rank; // This is computed in PHP, not selected from DB
        })
        ->editColumn('unit_name', function ($user) {
            return $user->unit->unit ?? 'N/A';
        })
        ->editColumn('role', function ($user) {
            return $this->getRoleName($user->is_role);
        })
        ->addColumn('action', function ($user) {
            return view('adminbackend.users.partials.actions', compact('user'))->render();
        })
        ->rawColumns(['action'])
        ->make(true);
}


    // ✅ Show create user form
    public function create()
{
    $nav_title = "Add Users";
    $units = \App\Models\Unit::orderBy('unit')->get();
    return view('superadmin.users.add', compact('nav_title', 'units'));
}


    // ✅ Store new user
   public function store(Request $request)
{
    $request->validate([
        'service_no'       => 'required|string|unique:users',
        'rank'             => 'required|string|max:50',
        'fname'            => 'required|string|max:255',
        'unit_id'          => 'required|exists:units,id', // ✅ foreign key validation
        'arm_of_service'   => 'nullable|in:ARMY,NAVY,AIRFORCE',
        'gender'           => 'nullable|in:Male,Female',
        'email'            => 'required|email|unique:users',
        'phone'            => 'nullable|string|max:20',
        'is_role'          => 'required|integer',
    ]);

    User::create([
        'service_no'       => trim($request->service_no),
        'rank'             => trim($request->rank),
        'fname'            => trim($request->fname),
        'unit_id'          => $request->unit_id,   // ✅ store foreign key
        'arm_of_service'   => $request->arm_of_service,
        'gender'           => $request->gender,
        'email'            => trim($request->email),
        'phone'            => trim($request->phone),
        'password'         => Hash::make('123456'),
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
    $nav_title = "Edit User";
    $units = \App\Models\Unit::orderBy('unit')->get();

    return view('superadmin.users.edit', compact('user', 'nav_title', 'units'));
}


    // ✅ Update user
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'service_no'       => 'required|string|unique:users,service_no,' . $user->id,
        'rank'             => 'required|string|max:50',
        'fname'            => 'required|string|max:255',
        'unit_id'          => 'required|exists:units,id', // ✅ foreign key validation
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
        'unit_id'          => $request->unit_id,  // ✅ update unit_id
        'arm_of_service'   => $request->arm_of_service,
        'gender'           => $request->gender,
        'email'            => trim($request->email),
        'phone'            => trim($request->phone),
        'is_role'          => $request->is_role,
    ]);

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
        $user->save();
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
