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


}
