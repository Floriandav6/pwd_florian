<?php
namespace App\Controller;

use App\Form\ContactType;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Entity\Advert;
use App\Entity\AdvertLike;
use App\Form\LikeFormType;
use App\Repository\AdvertLikeRepository;
use App\Repository\AdvertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;


class DefaultController extends AbstractController


{

    public function __construct(private EntityManagerInterface $em)
    {

    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('pages/home.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */

    public function contact(Request $request,EntityManagerInterface $em)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();
            $em->persist($data);
            $em->flush();

        }


        return $this->render('pages/contact.html.twig',[
            'formulaire' => $form->createView() ]);
    }


// Affichage des annonces
    /**
     * @Route("/advert/{id}", name="advert")
     */

    public function advert(int $id,
                           AdvertRepository $advertRepository,
                           Request $request,
                           AdvertLikeRepository $advertLikeRepository,
                           UserRepository $userRepository): Response
    {
        $objadvert = new AdvertLike();
        $likeform = $this -> createForm(LikeFormType::class,$objadvert);
        $likeform ->handleRequest($request);

        if ($likeform -> isSubmitted() && $likeform -> isValid()) {
            $data = $likeform->getData();
            $find =  $advertLikeRepository -> findOneBy(['advert' => $data->getAdvert() ->getId(),'user' => $data->getUser() ->getId()]);

            if ($find == null ){

                $this->em->persist($data);
                $this->em->flush();
            }
        }

        $advert = $advertRepository->find($id);



        return $this->render('pages/product.html.twig',['advert' => $advert,'form'=> $likeform -> createView()]);


    }
    /**
     * @Route("/advert/{id}/like", name="like")
     */
    public function like (Advert $advert, AdvertLikeRepository $advertLikeRepository): Response
    {
        $user = $this->getUser();
        if (!$user) return $this->json([
            'code' => 403,
            'message' => 'Vous devez être connecté'
        ],403);

        if ($advert->isLikedByUser($user)){
            $target = $advertLikeRepository->findOneBy(['user'=>$user,'advert'=>$advert]);

            $this->em->remove($target);
            $this->em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Annonce déliké',
                'like' => $advertLikeRepository->count(['advert'=>$advert])

            ]);

        } else {
            $like = new AdvertLike();
            $like ->setAdvert($advert)
                    ->setUser($user);

                $this->em->persist($like);
                $this->em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Annonce liké',
                'like' => $advertLikeRepository->count(['advert'=>$advert])
            ]);

        }
    }

 }
