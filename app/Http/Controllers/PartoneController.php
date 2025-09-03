<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartoneController extends Controller
{
    public function partone()
    {
        $nav_title = "Partone Orders";
        return view('superadmin.partone', compact('nav_title'));
    }
}
