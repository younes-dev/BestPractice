<?php

namespace App\EventSubscriber;

use App\Entity\Article;
use App\Helper\UploaderHelper;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderSubscriber implements EventSubscriber
{

    /**
     * @var UploaderHelper
     */
    private UploaderHelper $uploaderHelper;

    /**
     * FileUploaderSubscriber constructor.
     * @param UploaderHelper $uploaderHelper
     */
    public function __construct(UploaderHelper $uploaderHelper)
    {
        $this->uploaderHelper = $uploaderHelper;
    }

    /**
     * @return array
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
     */
    public function prePersist(LifecycleEventArgs $args):void
    {
        /** @var Article $entity */
        $entity = $args->getEntity();
//        dd($entity);

        if (!$this->supports($entity)) {
            return;
        }

        /** @var UploadedFile $picture */
        $picture = $entity->getPicture();
        $newFilename = $this->uploaderHelper->uploadImage($picture);
        $entity->setPicture($newFilename);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args):void
    {
        /** @var Article $entity */
        $entity = $args->getEntity();

        if (!$this->supports($entity)) {
            $entity->setPicture($this->recoverOldPicture($args, $entity));
            return;
        }

        /** @var UploadedFile $picture */
        $picture = $entity->getPicture();

        $this->removeOldPicture($args, $entity);

        $newFilename = $this->uploaderHelper->uploadImage($picture);
        $entity->setPicture($newFilename);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args):void
    {
        /** @var Article $entity */
        $entity = $args->getEntity();

        if (!$this->supports($entity)) {
            return;
        }

        $this->removeOldPicture($args, $entity);
    }

    /**
     * @param Object $entity
     * @return bool
     */
    public function supports(object $entity): bool
    {
        return $entity instanceof Article && !is_null($entity->getPicture());
    }

    /**
     * @param LifecycleEventArgs $args
     * @param Article $entity
     */
    public function removeOldPicture(LifecycleEventArgs $args, Article $entity): void
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();
        $entityChangeSet = $uow->getEntityChangeSet($entity);
        $picture = !empty($entityChangeSet['picture'][0]) ? $entityChangeSet['picture'][0] : $entity->getPicture();

        $this->uploaderHelper->removeImage($picture);
    }

    /**
     * @param LifecycleEventArgs $args
     * @param Article $entity
     * @return string
     */
    public function recoverOldPicture(LifecycleEventArgs $args, Article $entity)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();
        $entityChangeSet = $uow->getEntityChangeSet($entity);

        return $entityChangeSet['picture'][0] ?? null;
    }

}
