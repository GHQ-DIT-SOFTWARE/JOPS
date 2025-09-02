<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BroadcastController extends Controller
{
    public function broadcast()
    {
        $nav_title = "Broadcast";
        return view('superadmin.broadcast', compact('nav_title'));
    }
}
