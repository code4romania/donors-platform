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
            ->subject(__('auth.welcome.title'))
            ->line(__('auth.welcome.why'))
            ->action(__('auth.welcome.action'), $this->showWelcomeFormUrl)
            ->line(__('auth.welcome.expires', ['count' => $this->validUntil->diffInDays()]));
    }
}
