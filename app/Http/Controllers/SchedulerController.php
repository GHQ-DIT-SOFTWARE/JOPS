<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchedulerController extends Controller
{
    public function scheduler()
    {

         $nav_title = "Scheduler";
        return view('superadmin.scheduler', compact('nav_title'));
    }

}
