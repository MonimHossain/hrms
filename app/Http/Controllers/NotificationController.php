<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class NotificationController extends Controller
{
    public function markAsRead($id){
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }
        return ($notification);
    }

    public function markAllRead(User $user){
        $user->unreadNotifications->markAsRead();
        //return redirect()->back();
        return response()->json(['success' => 'success'], 200);
    }

    public function deleteAll(User $user){
        $user->notifications()->delete();
        return response()->json(['success' => 'success'], 200);
    }
}
