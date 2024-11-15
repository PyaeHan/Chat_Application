<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\GroupMessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chat');
    }

    public function fetchFriends()
    {
        $user = Auth::user();
        return User::where('id', '!=', $user->id)->get();
    }

    public function fetchMessages($friendId)
    {
        $user = Auth::user();
        return Message::where(function ($query) use ($user, $friendId) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $friendId);
        })
            ->orWhere(function ($query) use ($user, $friendId) {
                $query->where('sender_id', $friendId)
                    ->where('receiver_id', $user->id);
            })
            ->with(['sender', 'receiver'])
            ->get();
    }

    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'sender_id' => $request->input('sender_id'),
            'receiver_id' => $request->input('receiver_id'),
            'message' => $request->input('message'),
        ]);
        $message->load('sender');

        broadcast(new MessageSent($message))->toOthers();

        return ['status' => 'Message sent successfully!'];
    }

    public function groupMessages()
    {
        $user = Auth::user();
        $friends = User::where('id', '!=', $user->id)->get();

        return view('groupmessaging', compact('friends'));
    }

    public function sendGroupMessages(GroupMessageRequest $request)
    {
        $sender_id = Auth::id();
        $message = $request->input('message');
        $friend_ids = $request->input('friend_ids');
        $now = now();

        // Prepare the data for bulk insertion
        $messages = [];
        foreach ($friend_ids as $friend_id) {
            $messages[] = [
                'sender_id' => $sender_id,
                'receiver_id' => $friend_id,
                'message' => $message,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::beginTransaction();

        try {
            Message::insert($messages);
            DB::commit();

            $messages = Message::whereIn('receiver_id', $friend_ids)
                ->where('sender_id', $sender_id)
                ->where('message', $message)
                ->latest('created_at')
                ->get();

            foreach ($messages as $message) {
                $message->load('sender');
                broadcast(new MessageSent($message))->toOthers();
            }

            return redirect()->route('users.index')
            ->with('success', 'Group message sent successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            info($e->getMessage());
            return redirect()->route('users.index')
            ->with('delete_error','Unfortunately, group message sent failed.');
        }
    }
}
