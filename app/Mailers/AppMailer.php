<?php

namespace App\Mailers;

use App\User;
use Illuminate\Contracts\Mail\Mailer;

class AppMailer
{
    protected $mailer;
    protected $from = 'qwerty124563@gmail.com';
    protected $to;
    protected $view;
    protected $data = [];

    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
    }

    public function sendEmailConfirmationTo(User $user) {

        $this->to = $user->email;
        $this->view = 'emails.confirm';
        $this->data = compact('user');

        $this->deliver();

    }

    public function deliver() {
        $this->mailer->send($this->view, $this->data, function($message) {
            $message->from($this->from, 'Email verification')->subject('Activate your account!')
                ->to($this->to);
        });
    }
}
