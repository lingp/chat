<?php
namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function Index(Request $request)
    {
        $room_id = $request->input("room_id");

        return view('chat.index',[
            "room_id"=>$room_id?$room_id:"1"
        ]);
    }
}