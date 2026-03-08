<?php

namespace App\Jobs;

use App\Models\Sms;
use App\Models\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $students;
    protected $message;
    protected $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($students, $message, $userId)
    {
        $this->students = $students;
        $this->message = $message;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->students as $student) {
            $date = Carbon::now()->setTimezone('Asia/Tashkent')->format('Y-m-d H:i:s');

            $sms = SmsService::send_sms($student->phone, $this->message);
            SmsService::send_sms($student->parent_phone, $this->message);

            Sms::create([
                'student_id' => $student->id,
                'user_id' => $this->userId,
                'text' => $this->message,
                'date' => $date,
                'service_id' => $sms->service_id,
                'status' => $sms->status
            ]);
        }
    }
}
