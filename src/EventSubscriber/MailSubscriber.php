<?php

namespace App\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailSubscriber implements EventSubscriber
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
            Events::preRemove,
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        return $args->getEntity();
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        //dd('here');
        //$args->getEntity();
        $this->sendEmail();
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        return $args->getEntity();
    }

    public function sendEmail(): void
    {
        $email = (new Email())
            ->from('younes.oulkaid@gmail.com')
            ->to('younes.oulkaid@gmail.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            dd($e->getMessage());
            //throw new Exception('Sorry your email was not Sent Try Again ');
        }
    }
}
