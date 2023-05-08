<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages =  Message::orderBy('is_seen','asc')
        ->orderByDesc('id')
        ->paginate();
    
        return view('messages.index',compact('messages'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Message $message)
    {

        if($request->boolean('is_seen')) {
            $message->notification()->update(['is_seen'=>1]);  
            return redirect()->route('messages.show',['message'=>$message->id]);
        }
        return view('messages.show',compact('message'));
    }
   
    public function destroy(Message $message)
    {
    
        if($message->delete()){
            return redirect()
            ->route('messages.index')
            ->with(['message' => ['تم حذف المقاس بنجاح', 'success']]);
        }
    }
}
