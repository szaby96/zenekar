<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Event;

class EventCreated extends Notification implements ShouldQueue
{
    use Queueable;

    private $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
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
        if($this->event->visibility_id == 1){
            return (new MailMessage)
            ->line($this->event->user->name .' egy új publikus eseményt hozott létre.')
            ->action('Esemény megtekintése', route('event.show', $this->event->id))
            ->line('Tekintsd meg most!');
         }elseif($this->event->visibility_id == 2){
            return (new MailMessage)
            ->line($this->event->user->name .' egy új privát eseményt hozott létre.')
            ->action('Esemény megtekintése', route('event.show', $this->event->id))
            ->line('Tekintsd meg most!');
         }elseif($this->event->visibility_id == 3){
            return (new MailMessage)
            ->line($this->event->user->name .' egy új eseményt hozott létre a '. $this->event->instrument->name .' szólam számára.')
            ->action('Esemény megtekintése', route('event.show', $this->event->id))
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
