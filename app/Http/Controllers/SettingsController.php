<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function setting()
    {
        $nav_title = "Settings";
        return view('superadmin.setting', compact('nav_title'));
    }
}
