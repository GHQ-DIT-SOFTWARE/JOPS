<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function operation()
    {
        $nav_title = "Operations";
        return view('superadmin.operation', compact('nav_title'));
    }
}
