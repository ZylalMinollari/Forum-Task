<?php

namespace App\Http\Controllers\Pages;

use App\Models\Replay;
use App\Jobs\CreateReply;
use App\Policies\ReplyPolicy;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\CreateReplyRequest;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, EnsureEmailIsVerified::class]);
    }

    public function store(CreateReplyRequest $request) {

        //$this->authorize(ReplyPolicy::CREATE, Replay::class);

        $this->dispatchSync(CreateReply::fromRequest($request));

        return back()->with('success', 'Replay Created');
    }

    public function redirect($id, $type)
    {
        $reply = Replay::where('replyable_id', $id)->where('replyable_type', $type)->firstOrFail();

        return redirect()->route('threads.show', [$reply->replyAble()->category->slug(), $reply->replyAble()->slug()]);
    }
}
