<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class NotificationNewDocument implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_post;
    public $message;
   
    public function __construct($data_pusher)
    {
        $this->user_post = $data_pusher['user_post'];
        $this->message = $data_pusher['message'];
    }

    
    public function broadcastOn(): array
    {
        return new PrivateChannel('notification-new-document');
    }
    public function broadcastAs(): string
    {
        return 'NotificationNewDocument';
    }
    public function broadcastWith(): array
    {
        return [
            'user_post' => $this->user_post,
            'message' => $this->message,
        ];
    }
}
