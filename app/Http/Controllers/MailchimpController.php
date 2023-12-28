<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DrewM\MailChimp\MailChimp;
use Carbon\Carbon;
class MailchimpController extends Controller
{
    public function scheduleEmail()
    {
        $campaignData = [
            'type' => 'regular',
            'recipients' => ['list_id' => env("MAILCHIMP_LIST_ID")],
            'settings' => [
                'subject_line' => 'Your Line',
                'from_name' => 'Your Name',
                'reply_to' => 'phamductaidtsomuch@gmail.com',
                'template_id'=>10030042,
            ],
        ];

        $apiKey = env("MAILCHIMP_API_KEY");
        $MailChimp = new MailChimp($apiKey);
        $result = $MailChimp->post('campaigns', $campaignData);
        // return $result;

        $campaignId = $result['id'];

        $sendResult = $MailChimp->post("campaigns/{$campaignId}/actions/send");
        return $sendResult;
    }
    public function addSubcribe(){
        $apiKey = env("MAILCHIMP_API_KEY");
        $MailChimp = new MailChimp($apiKey);
        $list_id =env("MAILCHIMP_LIST_ID");
        $result = $MailChimp->post("lists/$list_id/members", [
            'email_address' => 'lehieunghia2402@gmail.com',
            'status'        => 'subscribed',
        ]);
        print_r($result);
    }
}
