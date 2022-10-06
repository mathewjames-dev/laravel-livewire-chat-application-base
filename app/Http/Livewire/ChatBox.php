<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatBox extends Component
{
    public $chats; // Chats that our authenticated user is linked to.
    public $activeChat; // Active chat variable for the active chat.
    public $message; // Message variable to house the message input value.
    public $users; // Variable to house all app users that you do NOT have a 1-1 chat with.

    // Mount function for when the component is initialized.
    public function mount()
    {
        $this->chats = Auth::user()->chats; // Get the chats for the user.

        // Now lets get the latest chat and set that to the active chat.
        $this->activeChat = Auth::user()->chats()->latest()->first();

        $this->users = User::with(['chats' => function ($q) {
            $q->wherePivot('user_id', '!=', Auth::user()->id)
                ->where('group_chat', 0);
        }])->get();
        dd($this->users);
    }

    public function render()
    {
        return view('livewire.chat-box');
    }

    // Function for when a navigation chat is clicked.
    public function navigationChatClicked($chatId)
    {
        // Get the chat record.
        $chatRecord = Auth::user()->chats()->where('chats.id', $chatId)->first();

        // Set the active chat variable to the chat record.
        $this->activeChat = $chatRecord;
    }

    // Function for sending a message.
    public function sendMessage()
    {
        // Create the message.
        $this->activeChat->messages()->create([
            'message' => $this->message,
            'user_id' => Auth::user()->id
        ]);

        // Clear the message value.
        $this->message = '';

        // Refresh the main active chat model.
        $this->activeChat->refresh();
    }

    // Function to refresh the messages.
    public function refreshMessages()
    {
        if ($this->activeChat) {

            // Refresh the main active chat model.
            $this->activeChat->refresh();

            // Get the latest chats for the user.
            $this->chats = Auth::user()->chats;
        }
    }
}
