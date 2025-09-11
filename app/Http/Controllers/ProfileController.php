<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
  use App\Models\Rank;
use App\Models\Unit;
use App\Models\DutyOfficerAccount;
use Carbon\Carbon;


class ProfileController extends Controller
{
    // View Profile
    public function ProfileView()
{
    $user = Auth::user()->load('unit'); // eager load the unit relation
    $nav_title = "User Profile";

    return view("user.view_profile", compact("user", "nav_title"));
}


 

public function ProfileEdit()
{
    $user = Auth::user();
    $nav_title = "Edit Profile";

    // Fetch all ranks and units
    $ranks = Rank::all();
    $units = Unit::all();

    return view("user.edit_profile", compact("user", "nav_title", "ranks", "units"));
}


    // Store Updated Profile
    public function ProfileStore(Request $request)
    {
        $request->validate([
            'rank_id'         => 'required|exists:ranks,id',    // ✅ validate foreign key
            'fname'           => 'required|string|max:255',
            'unit_id'         => 'required|exists:units,id',    // ✅ foreign key validation
            'gender'          => 'nullable|in:Male,Female',
            'arm_of_service'  => 'nullable|in:ARMY,NAVY,AIRFORCE',
            'phone'           => 'nullable|string|max:20',
            'email'           => 'nullable|email|max:255',
        ]);

        $user = Auth::user();
        $user->fill($request->only([
            'rank_id', 'fname', 'unit_id',  // ✅ changed from 'rank' to 'rank_id'
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

        // Clear temp password info to stop modal from showing
        DutyOfficerAccount::where('user_id', $user->id)->update([
            'temp_password_hash' => null,
            'temp_password_expires_at' => null,
            'show_temp_password' => null,
            'account_created' => true,  // or whatever flag indicates password changed
        ]);

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
