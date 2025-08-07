<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Profile;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('admin.pages.profile.index');
    }
}
