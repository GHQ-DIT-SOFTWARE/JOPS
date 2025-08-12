<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailsController extends Controller
{
    public function mails()
    {

         $nav_title = "Mails";
        return view('superadmin.mails', compact('nav_title'));
    }

}
