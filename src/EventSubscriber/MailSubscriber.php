<?php

namespace App\EventSubscriber;

use App\Entity\Article;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use UnexpectedValueException;

/**
 * Class MailSubscriber
 * @package App\EventSubscriber
 */
class MailSubscriber implements EventSubscriber
{
    private static array $operations = ["insert" => "Inserted", "update" => "Updated", "remove" => "Removed"];
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

    /**
     * @param LifecycleEventArgs $args
     * @codeCoverageIgnore
     */
    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->sendEmail($this->getInfo($args), self::$operations["insert"]);
    }

    /**
     * @param LifecycleEventArgs $args
     * @codeCoverageIgnore
     */
    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->sendEmail($this->getInfo($args), self::$operations["update"]);
    }

    /**
     * @param LifecycleEventArgs $args
     * @codeCoverageIgnore
     */
    public function preRemove(LifecycleEventArgs $args): void
    {
        $this->sendEmail($this->getInfo($args), self::$operations["remove"]);
    }

    /**
     * @codeCoverageIgnore
     * @param array $info
     * @param string $operations
     */
    public function sendEmail(array $info, string $operations): void
    {
        $msg = null;
        if (!$info["id"]) {
            $msg = sprintf('The Author : %s %s A New Article At :  %s', $info["author"], $operations, $info["dateEvent"]);
        }

        if ($info["id"]) {
            $msg = sprintf('The Author %s %s The Article Id : %s At :  %s', $info["author"], $operations, $info["id"], $info["dateEvent"]);
        }
        $email = (new Email())
            ->from('younes.oulkaid@gmail.com')
            ->to('younes.oulkaid@gmail.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html($msg);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            throw new UnexpectedValueException($e->getMessage());
        }
    }

    /**
     * @param LifecycleEventArgs $args
     * @return array
     * @codeCoverageIgnore
     */
    private function getInfo(LifecycleEventArgs $args): array
    {
        /**
         * @var Article $entity
         */
        $entity = $args->getEntity();
        return [
            'id' => $entity->getId(),
            'name' => $entity->getName(),
            'content' => $entity->getContent(),
            'author' => $entity->getAuthor(),
            'category' => $entity->getCategory(),
            'dateEvent' => date_format(new DateTime(), "H:i:s d/m/Y"),
        ];
    }
}
