<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function open(Request $request, string $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $url = $notification->data['url'] ?? route('dashboard');
        $baseUrl = rtrim(url('/'), '/');
        abort_unless($url === $baseUrl || str_starts_with($url, $baseUrl.'/'), 400);
        $notification->markAsRead();

        return redirect($url);
    }

    public function readAll(Request $request)
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return back();
    }
}
