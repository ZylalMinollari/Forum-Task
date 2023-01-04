<?php

namespace App\Events;

use App\Models\Replay;
use Illuminate\Queue\SerializesModels;

class ReplyWasCreated
{
    use SerializesModels;

    public $reply;

    public function __construct(Replay $reply)
    {
        $this->reply = $reply;
    }
}
