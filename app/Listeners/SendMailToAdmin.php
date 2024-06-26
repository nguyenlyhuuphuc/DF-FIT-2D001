<?php

namespace App\Listeners;

use App\Events\OrderSuccessEvent;
use App\Mail\OrderEmailAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailToAdmin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderSuccessEvent $event): void
    {
        $order = $event->order;
        
        Mail::to('nguyenlyhuuphucwork@gmail.com')->send(new OrderEmailAdmin($order));
    }
}
