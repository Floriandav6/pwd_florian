<?php

namespace App\Controller;

use App\Form\RegistrationType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;


class SecurityController extends AbstractController
{

    /**
     * @Route("/register", name="register")
     */
    public function registration(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $encoder) {

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
        // On encode le mot de passe avant de persister
            $factory = new PasswordHasherFactory([
                'common' => ['algorithm' => 'bcrypt'],
                'memory-hard' => ['algorithm' => 'sodium'],
            ]);


            $passwordHasher = $factory->getPasswordHasher('common');
            $hash = $passwordHasher->hash('plain');
            $user->setPassword($hash);
            $em ->persist($user);
            $em->flush();
            return $this->redirectToRoute('connect');
        }

        return $this->render('security/signin.html.twig', ['form' => $form->createView() ]);

    }
    /**
 * @Route("/connect", name="connect")
 */

        public function login(){
        return $this->render('security/connect.html.twig');
        }
}
