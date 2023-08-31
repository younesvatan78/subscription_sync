<?php
namespace App\Mail;
use Illuminate\Mail\Mailable;

class SendExpiredNotifyMailToAdmin extends Mailable{
    public $data;
    public function __construct($data){
        $this->data = $data;
    }
    public function make_mail(){
        return $this->subject('Expired Subscriber form Subscription sync parspack')->view('emails.notify_admin_expiredsubs')
        ->with('data',$this->data);
    }
}