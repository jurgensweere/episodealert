<?php namespace EA;

use App;
use DB;
use Log;
use DateTime;
use Mail;

class MailJob
{
    public function sendAlertEmail($job, $data)
    {

        Mail::send(array('emails.alert.richtext', 'emails.alert.text'), $data, function ($message) use ($data) {

            $message->to($data['email'], $data['username'])
                ->from('alerts@episode-alert.com')
                ->subject("New Episode Alert");
        });

        $job->delete();


//        $following = Following::find(intval($data['following_id']));
//        $episode = Episode::find(intval($data['episode_id']));
//
//        if ($following == null) {
//            Log::info("MailJob.sendAlertEmail: Invalid Following Id");
//            $job->delete();
//        }
//
//        Log::info("MailJob.sendAlertEmail: Processing: {$episode->series->name} S{$episode->season}E{$episode->episode}");
//
//        $data = array(
//            'series' => $episode->series->name,
//            'season' => $episode->season,
//            'episode' => $episode->episode,
//            'airdate' => $episode->airdate,
//            'epsiodeName' => $episode->name,
//            'episodeDescription' => $episode->description,
//            'username' => $following->user->accountname,
//        );
//
//        Mail::send(array('emails.alert.richtext', 'emails.alert.text'), $data, function($message) use ($following)
//        {
//            $message->to($following->user->email, $following->user->accountname)
//                ->from('alerts@episode-alert.com')
//                ->subject("New Episode Alert");
//        });
//
//        // mark this user that he had a notification
//        $following->last_notified = new DateTime;
//        $following->save();
//
//        $job->delete();
    }
}
