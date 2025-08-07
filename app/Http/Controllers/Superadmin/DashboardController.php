<?php
declare(strict_types=1);
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

         $nav_title = "Dashboard";
        return view('superadmin.dashboard', compact('nav_title'));
    }
}
