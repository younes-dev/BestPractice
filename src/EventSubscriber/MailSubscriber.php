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

    /**
     * MailSubscriber constructor.
     * @param MailerInterface $mailer
     * @codeCoverageIgnore
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
            Events::preRemove,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): object
    {
        return $args->getEntity();
    }

    /**
     * @param LifecycleEventArgs $args
     * @codeCoverageIgnore
     */
    public function preUpdate(LifecycleEventArgs $args): void
    {
        $args->getEntity();
        $this->sendEmail();
    }

    /**
     * @param LifecycleEventArgs $args
     * @return object
     *  @codeCoverageIgnore
     */
    public function preRemove(LifecycleEventArgs $args): object
    {
        return $args->getEntity();
    }

    /**
     * @codeCoverageIgnore
     */
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