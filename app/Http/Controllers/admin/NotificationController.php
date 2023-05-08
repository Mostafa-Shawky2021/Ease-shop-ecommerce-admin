<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    //
    public function index()
    {
        $notifications = Notification::orderBy('is_seen', 'asc')
            ->orderBy('id', 'desc')
            ->paginate();
        return view('notifications.index', compact('notifications'));
    }
    public function update(Notification $notification)
    {
        $notification->is_seen=1;
        
        if ($notification->save()) {
            return redirect()->route('notifications.index')->with(['message' => ['success', 'تم التحديث بنجاح']]);
        }
        return redirect()->route('notifications.index')->with(['message' => ['error', 'حدثت مشكلة اثناء التحديث حاول مرة اخري']]);
    }
    public function destroy(Notification $notification)
    {
        if ($notification->delete()) {
            return redirect()->route('notifications.index')
                ->with(['message' => ['success', 'تم الحذف بنجاح']]);
        }
        return redirect()->route('notifications.index')
            ->with(['message' => ['error', 'حدثت مشكله اثناء الحذف حاول مرة اخري']]);
    }



}