<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.index');
    }
}
