<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use \DrewM\MailChimp\MailChimp;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $campaignData = [
                'type' => 'regular',
                'recipients' => ['list_id' => env("MAILCHIMP_LIST_ID")],
                'settings' => [
                    'subject_line' => 'Your Line',
                    'from_name' => 'Your Name',
                    'reply_to' => 'phamductaidtsomuch@gmail.com',
                    'template_id'=>10030054,
                ],
            ];
    
            $apiKey = env("MAILCHIMP_API_KEY");
            $MailChimp = new MailChimp($apiKey);
            $result = $MailChimp->post('campaigns', $campaignData);
    
            $campaignId = $result['id'];
    
            $sendResult = $MailChimp->post("campaigns/{$campaignId}/actions/send");
            echo "giigigi";
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
