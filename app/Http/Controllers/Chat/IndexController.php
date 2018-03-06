<?php
namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function Index()
    {
        return view('chat.index');
    }
}