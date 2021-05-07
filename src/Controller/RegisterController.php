<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = new user();
        $user->setRoles(['ROLE_USER']);

        $formInscription = $this->createForm(RegistrationType::class, $user);

        $formInscription->handleRequest($request);

        if ($formInscription->isSubmitted() && $formInscription->isValid()){

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());

            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('register/index.html.twig',[
            'formInscription'=> $formInscription->createView()
        ]);
    }
    /**
     * @Route("/admin/new", name="app_ajoutAdmin")
     */
    public function registrationAdmin(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = new user();
        $user->setRoles(['ROLE_ADMIN']);

        $formInscriptionAdmin = $this->createForm(RegistrationType::class, $user);

        $formInscriptionAdmin->handleRequest($request);

        if ($formInscriptionAdmin->isSubmitted() && $formInscriptionAdmin->isValid()){

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());

            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('register/ajoutAdmin.html.twig',[
            'formInscriptionAdmin'=> $formInscriptionAdmin->createView()
        ]);
    }
}
