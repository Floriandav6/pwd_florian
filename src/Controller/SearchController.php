<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\AdvertRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route ("/category", name="category")
     */
    public function index(AdvertRepository $advertRepository,Request $request, PaginatorInterface $paginator)
    {
        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $adverts = $advertRepository->findSearch($data);

        $adverts = $paginator->paginate(
            $adverts, /* query NOT result */
            $request->query->getInt('page', 1),
            6/*limit per page*/);

        return $this->render('pages/category.html.twig', ['adverts'=> $adverts,'form' => $form->createView()]);

    }
}
