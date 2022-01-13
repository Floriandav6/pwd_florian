<?php
namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use App\Entity\Advert;
use App\Entity\AdvertLike;
use App\Form\LikeFormType;
use App\Repository\AdvertLikeRepository;
use App\Repository\AdvertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;


class DefaultController extends AbstractController


{
    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em)


{
    $this ->em=$em;
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

    public function contact()
    {
        return $this->render('pages/contact.html.twig');
    }


    /**
     * @Route("/account", name="account")
     */

    public function account()
    {
        return $this->render('pages/account.html.twig');
    }

    /**
     * @Route("/connect", name="connect")
     */

    public function connect()
    {
        return $this->render('pages/connect.html.twig');
    }

    /**
     * @Route("/signin", name="signin")
     */

    public function signin()
    {
        return $this->render('pages/signin.html.twig');
    }


    /**
     * @Route ("/category", name="category")
     */

    public function category(AdvertRepository $advertRepository,Request $request,AdvertLikeRepository $advertLikeRepository,UserRepository $userRepository): Response
    {
       $objadvert = new AdvertLike();
         // $likeform = $this -> createForm(LikeFormType::class,$objadvert);
        $likeform = $this -> createFormBuilder()
        ->add('advert')
        ->add('user')
            ->getForm();
        $likeform ->handleRequest($request);

        if ($likeform -> isSubmitted() && $likeform ->isValid()) {
            $data = $likeform ->getData();
            $find =  $advertLikeRepository -> findOneBy(['advert' => $data['advert'] ,'user' => $data['user']]);

            if (empty($find)){
                $varadvert = $advertRepository-> findOneBy(['id'=> $data['advert']]);
                $varuser = $userRepository-> findOneBy(['id'=> $data['user']]);
                $objadvert ->setAdvert($varadvert);
                $objadvert->setUser($varuser);

                $this->em->persist($objadvert);
                $this->em->flush();
            }
        }


        $adverts = $advertRepository ->findAllWithCategories();

        return $this->render('pages/category.html.twig', ['adverts'=> $adverts,'form'=> $likeform -> createView()]);
    }


    /**
     * @Route ("/category/multi", name="multi")
     */

    public function multi(AdvertRepository $advertRepository): Response
    {
        $adverts = $advertRepository ->findBy(array('category' => 1));
        return $this->render('pages/category.html.twig', ['adverts'=> $adverts]);
    }

    /**
     * @Route ("/category/crampons", name="crampons")
     */

    public function crampons(AdvertRepository $advertRepository): Response
    {
        $adverts = $advertRepository ->findBy(array('category' => 2));
        return $this->render('pages/category.html.twig', ['adverts'=> $adverts]);
    }

    /**
     * @Route ("/category/indoor", name="indoor")
     */

    public function indoor(AdvertRepository $advertRepository): Response
    {
        $adverts = $advertRepository ->findBy(array('category' => 3));
        return $this->render('pages/category.html.twig', ['adverts'=> $adverts]);
    }


    /**
     * @Route ("/category/synthetique", name="synthetique")
     */

    public function synthetique(AdvertRepository $advertRepository): Response
    {
        $adverts = $advertRepository ->findBy(array('category' => 4));
        return $this->render('pages/category.html.twig', ['adverts'=> $adverts]);
    }



    /**
     * @Route("/advert/{id}", name="advert")
     */

    public function advert(int $id,AdvertRepository $advertRepository): Response
    {


        $advert = $advertRepository->find($id);
        if ($advert === null) {
            throw new NotFoundHttpException("Advert inexistante");
        }



        return new Response("<h1>" .$advert->getTitle(). "</h1></body>");


    }
    /**
     * @Route("/new-advert", name="create_advert")
     */
    public function createAdvert(EntityManagerInterface $em): Response{

        $advert = new Advert();
        $advert->setTitle("ESSAI")
            ->setDescription("aaaaaaaazdzafzefzfzefzefzefzefezfze")
            ->setPrice(12)
            ->setBrand("Puma")
            ->setSize(44);

        $em->persist($advert);
        $em->flush();

        return new Response("essai 33");
    }


//    /**
  //   * @Route("/category/{id}", name="category")
    // */
   // public function category(int $id): Response
   // {
     //   return new Response("<h1>category " . $id . "</h1></body>");
   // }


    // /**
    //  * @Route("/a/{id}", name="view_advert")
    // */
    // public function viewAdvert(int $id): Response
    //  {
    //     return new Response("<h1>Annonces n°" . $id . "</h1></body>");
    // }
 }
