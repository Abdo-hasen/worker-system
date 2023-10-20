<?php

namespace App\Http\Controllers\Api\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Http\traits\ApiTrait;
use App\Models\Admin;

class AdminNotificationController extends Controller
{
    use ApiTrait;

    public function index()
    {
        $admin = auth("admin")->user();
        return $this->apiResponse(200,"Notification has been returned successfully","null",$admin->notifications);
    }

    public function unread()
    {
        $admin = Admin::find(auth()->id());
        return $this->apiResponse(200,"unreadNotification has been returned successfully","null",$admin->unreadNotifications);
    }

    public function mark($id)
    {
        $admin = auth("admin")->user();
        $notification = $admin->notifications->find($id);
        $notification->markAsRead();

        return $this->apiResponse(200,"The Notification has been marked successfully","null","null");
    }

    public function markAll()
    {
        $admin = Admin::find(auth()->id());
        $admin->unreadNotifications->markAsRead();
        return $this->apiResponse(200,"All Notification has been marked successfully","null","null");
    }

    
    public function destroy($id)
    {
        $notification = auth("admin")->user()->notifications->find($id);
        $notification->delete();//b-mark

        return $this->apiResponse(200,"The Notification has been destroyed successfully","null","null");
    }

    public function destroyAll()
    {
        $admin = Admin::find(auth()->id());
        $admin->notifications()->delete();
        return $this->apiResponse(200,"All Notification has been destroyed successfully","null","null");
    }


}

