<?php

namespace App\Controller\Admin;

use App\Entity\AdvertLike;
use App\Entity\Advert;
use App\Entity\Category;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/crud", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
                $url = $routeBuilder->setController(AdvertCrudController::class)->generateUrl();

               return $this->redirect($url);
       // return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Univers Crampons');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Retour au site', 'fas fa-home', 'home');
        yield MenuItem::linkToCrud('Annonces', 'fas fa-sticky-note', Advert::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-book-open', Category::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);

    }
}
