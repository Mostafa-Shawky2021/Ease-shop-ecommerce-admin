<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\StoreContactusRequest;
use App\Models\Message;
use App\Models\Notification;
class MessageController extends Controller
{
    //
    public function store(StoreContactusRequest $request){
      
        $validatedInput = $request->validated();
        $message = Message::create($validatedInput);
        
        if($message){
            $notification = new Notification();
            $notification->message =  "تم ارسال رسالة جديدة بواسطة {$request->input('username')}";
            $message->notification()->save($notification);
            return response([
                'message' =>'message created successfully', 
                'data'=>$message,
            ],201);
        }

        return response([
            'message' => 'error with creating new message' 
        ],422);
    }
}
