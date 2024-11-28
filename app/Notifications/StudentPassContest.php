<?php

namespace App\Notifications;

use App\Models\StudentExam;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\PassExam;

class StudentPassContest extends Notification
{
    use Queueable;
    protected $exam;
    public function __construct(StudentExam $exam)
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
        ];
    }
}
