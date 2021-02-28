<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Service\SaveDataService;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @var SaveDataService
     */
    private SaveDataService $saveData;

    public function __construct(SaveDataService $saveData)
    {
        $this->saveData = $saveData;
    }

    /**
     * @Route("/registration", name="registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     * @throws OptimisticLockException
     */
    public function addUser(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
//        if ($this->get('security.authorization_checker')->isGranted("ROLE_USER") === TRUE) {
//            // admin is logged in
//            return $this->redirectToRoute("admin");
//        }
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->saveData->save($user);
            return $this->redirectToRoute('app_login');
        }
        return $this->render('registration/index.html.twig', [
            'formUser' =>  $form->createView(),
        ]);
    }

}
