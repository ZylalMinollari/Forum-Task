<?php

namespace App\Http\Livewire\Reply;

use App\Models\Replay;
use Livewire\Component;
use App\Policies\ReplyPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Update extends Component
{
    use AuthorizesRequests;

    public $replyId;
    public $replyOrigBody;
    public $replyNewBody;
    public $author;
    public $createdAt;

    protected $listeners = ['deleteReply'];

    public function mount(Replay $reply)
    {
        $this->replyId = $reply->id();
        $this->replyOrigBody = $reply->body();
        $this->author = $reply->author();
        $this->createdAt = $reply->created_at;
        $this->initialize($reply);
    }

    public function updateReply()
    {
        $reply = Replay::findOrFail($this->replyId);

        $this->authorize(ReplyPolicy::UPDATE, $reply);

        $reply->body = $this->replyNewBody;
        $reply->save();
        $this->initialize($reply);
    }

    public function initialize(Replay $reply)
    {
        $this->replyOrigBody = $reply->body();
        $this->replyNewBody = $this->replyOrigBody;
    }

    public function deleteReply($page)
    {
        session()->flash('success', 'Reply Deleted!');
        return redirect()->to($page);
    }


    public function render()
    {
        return view('livewire.reply.update');
    }
}
