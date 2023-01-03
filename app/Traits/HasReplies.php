<?php

namespace App\Traits;

use App\Models\Replay;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasReplies
{
    public function replies()
    {
        return $this->repliesRelation;
    }

    public function latestReplies(int $amount = 5)
    {
        return $this->repliesRelation()->latest()->limit($amount)->get();
    }

    public function deleteReplies()
    {
        foreach ($this->repliesRelation()->get() as $reply) {
            $reply->delete();
        }

        $this->unsetRelation('repliesRelation');
    }

    public function repliesRelation(): MorphMany
    {
        return $this->morphMany(Replay::class, 'repliesRelation', 'replyable_type', 'replyable_id');
    }

    public function isConversationOld(): bool
    {
        $threeMonthsAgo = now()->subMonths(3);

        if ($reply = $this->repliesRelation()->latest()->first()) {
            return $reply->createdAt()->lt($threeMonthsAgo);
        }

        return $this->createdAt()->lt($threeMonthsAgo);
    }
}