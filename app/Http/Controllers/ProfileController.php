<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // View Profile
    public function ProfileView()
    {
        $user = Auth::user();
        $nav_title = "User Profile";

        return view("user.view_profile", compact("user", "nav_title"));
    }

    // Edit Profile
    public function ProfileEdit()
    {
        $user = Auth::user();
        $nav_title = "Edit Profile";

        return view("user.edit_profile", compact("user", "nav_title"));
    }

    public function ProfileStore(Request $request)
{
    $request->validate([
        
        'rank'            => 'required|string|max:50',
        'fname'           => 'required|string|max:255',
        'unit'            => 'required|string|max:255',
        'gender'          => 'nullable|in:Male,Female',
        'arm_of_service'  => 'nullable|in:ARMY,NAVY,AIRFORCE',
        'phone'           => 'nullable|string|max:20',
    ]);
    
    $user = Auth::user();
    $user->fill($request->only([
    'rank', 'fname', 'unit',
        'arm_of_service', 'gender', 'email', 'phone'
    ]));
    $user->save();

    return redirect()->route('profile.view')->with([
        'message' => 'Profile updated successfully.',
        'alert-type' => 'success'
    ]);
}


    // View Change Password Page
    public function PasswordView()
    {
        $nav_title = "Change Password";
        return view('user.edit_password', compact('nav_title'));
    }

    // Update Password
    public function PasswordUpdate(Request $request)
    {
        $request->validate([
            'oldpassword' => 'required',
            'password'    => 'required|confirmed|min:6',
        ]);

        if (Hash::check($request->oldpassword, Auth::user()->password)) {
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->save();

            Auth::logout();

            return redirect()->route('login')->with([
                'message' => 'Password updated successfully. Please log in again.',
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Current password is incorrect.',
                'alert-type' => 'error'
            ]);
        }
    }
}
