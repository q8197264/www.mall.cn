<?php
namespace App\Services;

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

/**
 * Created by PhpStorm.
 * User: liuxiaoquan
 * Date: 2018-11-22
 * Time: 21:21
 */
class NotifyService
{
    private $mail;

    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
    }

    public function send(array $request)
    {
        echo 'TestMail';
        echo config('MAIL_USERNAME');
        echo env('MAIL_USERNAME');
        return;
//        $this->mail->queue('email.index', $request, function (Message $mesage) {
//            $message->sender(env('MAIL_USERNAME'));
//            $message->subject(env('MAIL_SUBJECT'));
//            $message->to(env('MAIL_TO_ADDR'));
//        });
    }
}