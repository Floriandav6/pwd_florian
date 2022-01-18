<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Form\AdvertType;
use App\Repository\AdvertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {

    }
    /**
     * @Route("/account", name="account")
     */

    public function account (AdvertRepository $advertRepository): Response
    {
        $adverts = $advertRepository ->findBy(array('user' => 5 ));
        return $this->render('pages/account.html.twig', ['adverts'=> $adverts]);
    }
}
