<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Replay;
use App\Mail\NewReplyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewReplyNotification extends Notification
{
    use Queueable;

    public $reply;

    public function __construct(Replay $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(User $user)
    {
        return (new NewReplyEmail($this->reply))
            ->to($user->emailAddress(), $user->name());
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase(User $user)
    {
        return [
            'type'              => 'new_reply',
            'reply'             => $this->reply->id(),
            'replyable_id'      => $this->reply->replyable_id,
            'replyable_type'    => $this->reply->replyable_type,
            'replyable_subject' => $this->reply->replyable()->replyAbleSubject(),
        ];
    }
}
