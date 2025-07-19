<?php
namespace App\Http\Controllers;
  use DB;


use Illuminate\Http\Request;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Auth;

class CustomMessagesController extends Controller
{

public function unreadCount()
{
    $count = DB::table('ch_messages')
        ->where('to_id', Auth::id())
        ->where('seen', 0)
        ->count();

    return response()->json(['count' => $count]);
}

}
