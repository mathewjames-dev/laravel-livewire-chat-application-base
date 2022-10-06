<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    use HasFactory;

    protected $table = "chats";

    /*
        Relationship
    */

    // Users
    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_user', 'chat_id', 'user_id');
    }

    // Messages
    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_id', 'id');
    }


    /*
        Functions
    */

    // Function to see if the chat is a group chat.
    public function isGroupChat()
    {
        return $this->group_chat === 1;
    }
}
