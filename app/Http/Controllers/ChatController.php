<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (request()->segment(1) === 'admin') {
        return view('chat.index-admin');
        // } else {
        //     return view('chat.index');
        // }
    }

    public function chanels()
    {
        $data = Chat::with('user')->where('user_id', auth()->user()->id)->get();
        return response()->json(['message' => 'ok', 'data' => $data]);
    }

    public function chanelsAll()
    {
        $data = Chat::with('user')->get();
        return response()->json(['message' => 'ok', 'data' => $data]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chat = new Chat();
        $chat->merchant_id = 1; //auth()->user()->id;
        $chat->user_id = auth()->user()->id;
        $chat->save();
        return response()->json($chat);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->delete();
        return response()->json(['message' => 'ok', 'data' => $chat]);
    }

    /**
     * message
     */
    public function getMessage($id)
    {
        $message = Message::with('sender', 'reciver')->where('chat_id', $id)->limit(200)->orderBy('id', 'asc')->get();
        // broadcast event to channel admin
        // event(new MessageSent($message, 'admin'));
        // broadcast event to channel end user
        // event(new MessageSent($message, $id));

        return response()->json([
            'message' => 'ok',
            'data' => $message
        ]);
    }

    public function saveMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required'
        ]);

        $message = new Message();
        $message->chat_id = $id;
        $message->sender_id = auth()->user()->id;
        $message->reciver_id = 0;
        $message->content = $request->message;
        $message->save();

        $lastMessage = Message::with('sender', 'reciver')->findOrFail($message->id);
        // $lastMessage = Message::with('sender', 'reciver')->where([
        //     'chat_id' => $id,
        //     'id' => $message->id,
        // ])->limit(1)->orderBy('id', 'asc')->get();

        // broadcast event to channel admin
        event(new MessageSent($lastMessage, 'admin'));
        // broadcast event to channel end user
        event(new MessageSent($lastMessage, $id));

        return response()->json([
            'message' => 'ok',
            'data' => $lastMessage
        ]);
    }
}
