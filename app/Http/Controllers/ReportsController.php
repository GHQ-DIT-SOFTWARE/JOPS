<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function dutyReport()
    {

         $nav_title = "Duty Report";
        return view('superadmin.reports.dutyreport', compact('nav_title'));
    }

    public function dailySitrep()
    {

         $nav_title = "Daily Sitrep";
        return view('superadmin.reports.dailysitrep', compact('nav_title'));
    }

public function add()
{
    $nav_title = "Add Report";
    $user = auth()->user();  // get the logged-in user

    return view('superadmin.reports.addreport', compact('nav_title', 'user'));
}
}
