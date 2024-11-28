<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\PassExam;

class passTest extends Notification
{
    use Queueable;
    protected $exam;
    public function __construct(PassExam $exam)
    {
        $this->exam = $exam;
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toArray($notifiable)
    {
        return [
             'id' => $this->exam->id,
             'teacher_id' => $this->exam->teacher_id,
             'main_cat' => $this->exam->main_cat,
             'level' => $this->exam->level

        ];
    }
}
