<?php

namespace App\Jobs;

use App\Mail\ForgotPasswordEmail;
use App\Mail\VerificationEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $job_data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $job_data)
    {
        $this->job_data = $job_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $email_type = $this->job_data['email_type'];
            $user_data = $this->job_data['user_data'];

            switch ($email_type) {
                case "email_verification":
                    // Send email
                    Mail::to($user_data['user']->email)->send(new VerificationEmail($user_data));
                    break;
                case "forgot_password":
                    // Send email
                    Mail::to($user_data['user']->email)->send(new ForgotPasswordEmail($user_data));
                    break;
                default:

                    break;
            }
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
