<?php
namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

class SecurityEventsSubscriber implements EventSubscriberInterface
{
    public function __construct(private LoggerInterface $logger) {}

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccess',
            LoginFailureEvent::class => 'onLoginFailure',
        ];
    }

    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        /** @var \App\Entity\User */
        $user = $event->getUser();
        $this->logger->info('User logged in successfully', [
            'action'  => 'login',
            'ip'      => $event->getRequest()->getClientIp(),
            'user_id' => $user->getId(),
        ]);
    }

    public function onLoginFailure(LoginFailureEvent $event): void
    {
        $this->logger->warning('Authentication failed', [
            'action'    => 'login',
            'email'     => $event->getRequest()->get('_username'),
            'ip'        => $event->getRequest()->getClientIp(),
            'exception' => $event->getException()->getMessage(),
        ]);
    }
}
