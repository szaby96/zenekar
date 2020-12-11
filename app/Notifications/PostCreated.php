<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Post;

class PostCreated extends Notification implements ShouldQueue
{
    use Queueable;

    private $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
         if($this->post->visibility_id == 1){
            return (new MailMessage)
            ->line($this->post->user->name .' egy új publikus posztot hozott létre.')
            ->action('Poszt megtekintése', route('post.show', $this->post->id))
            ->line('Tekintsd meg most!');
         }elseif($this->post->visibility_id == 2){
            return (new MailMessage)
            ->line($this->post->user->name .' egy új privát posztot hozott létre.')
            ->action('Poszt megtekintése', route('post.show', $this->post->id))
            ->line('Tekintsd meg most!');
         }elseif($this->post->visibility_id == 3){
            return (new MailMessage)
            ->line($this->post->user->name .' egy új posztot hozott létre a '. $this->post->instrument->name .' szólam számára.')
            ->action('Poszt megtekintése', route('post.show', $this->post->id))
            ->line('Tekintsd meg most!');
         }

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
