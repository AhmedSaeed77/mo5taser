<?php

namespace App\Notifications;

use App\Models\StudentExam;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\PassExam;

class StudentTestCorrection extends Notification
{
    use Queueable;
    protected $exam;
    public function __construct($exam)
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
            'id' => $this->exam->content_id ?? $this->exam->exam_id,
            'user_id' => auth()->id(),
        ];
    }
}
