<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class ExportPdfStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected User $user;

    public string $message;

    public $link;

    public function __construct(User $user, array $payload)
    {
        $this->user    = $user;
        $this->message = Arr::pull($payload, 'message');
        $this->link    = Arr::pull($payload, 'link');
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.'.$this->user->id);
    }
}
