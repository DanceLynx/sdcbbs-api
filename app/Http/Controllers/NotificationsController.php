<?php
/*
 * @Author: DanceLynx
 * @Description: 消息通知控制器
 * @Date: 2020-06-26 08:21:52
 */

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(5);
        Auth::user()->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
