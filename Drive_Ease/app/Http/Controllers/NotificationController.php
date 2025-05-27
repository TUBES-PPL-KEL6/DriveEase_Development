<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function store(Request $request)
    {
        $notification = Notification::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'status' => $request->status,
            'link' => $request->link,
        ]);
        return response()->json(
            [
                'status' => '200',
                'message' => 'Notification created successfully',
                'data' => $notification
            ]
        );
    }

    public function countNotification()
    {
        $count = Notification::where('user_id', auth()->user()->id)->where('status', 'unread')->count();
        return response()->json($count);
    }


    public function fetchNotifications()
    {
        $notifications = Notification::where('user_id', auth()->user()->id)->where('status', 'unread')->latest()->get();
        return response()->json($notifications);
    }

    public function markAsRead(Request $request)
    {
        $notification = Notification::find($request->id);
        $notification->status = 'read';
        $notification->save();
        return response()->json([
            'status' => '200',
            'message' => 'Notification marked as read successfully',
            'data' => $notification
        ]);
    }
}
