<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;

class SaveDataService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param object $objet
     * @throws OptimisticLockException
     */
    public function save(object $objet): void
    {
        try {
            if(!$objet->getId()){
                $this->manager->persist($objet);
                $this->manager->flush();
            }
            $this->manager->flush();
        } catch (OptimisticLockException $e) {
            throw new OptimisticLockException($e->getMessage(), $objet);
        }
    }


    /**
     * @param object $objet
     * @throws OptimisticLockException
     */
    public function remove(object $objet): void
    {
        try {
            if($objet->getId()){
                $this->manager->remove($objet);
                $this->manager->flush();
            }

        } catch (OptimisticLockException $e) {
            throw new OptimisticLockException($e->getMessage(), $objet);
        }
    }

}
