<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Spatie\WelcomeNotification\WelcomeNotification;

class InitialPasswordSetup extends WelcomeNotification
{
    // use Queueable;

    protected function buildWelcomeNotificationMessage(): MailMessage
    {
        return (new MailMessage)
            ->subject(__('email.welcome.title'))
            ->line(__('email.welcome.why'))
            ->action(__('email.welcome.action'), $this->showWelcomeFormUrl)
            ->line(__('email.welcome.expires', ['count' => $this->validUntil->diffInDays()]));
    }
}
