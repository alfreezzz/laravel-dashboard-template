<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a list of the user's notifications.
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->limit(50)->get();

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead(\App\Models\Notification $notification)
    {
        $this->authorize('view', $notification);

        $notification->update(['read_at' => now()]);

        return back();
    }

    /**
     * Mark all notifications for the current user as read.
     */
    public function markAllRead()
    {
        auth()->user()->notifications()->whereNull('read_at')->update(['read_at' => now()]);

        return back();
    }
}
