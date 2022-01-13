<?php

namespace App\Controller\Admin;

use App\Entity\AdvertLike;
use App\Entity\Advert;
use App\Entity\Category;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
       // return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Pwd Florian');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Retour au site', 'fas fa-home', 'home');
        yield MenuItem::linkToCrud('Advert', 'fas fa-map-marker-alt', Advert::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-book-open', Category::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);

    }
}
