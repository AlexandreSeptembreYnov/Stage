<?php


namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    /**
     * @var UserRepository
     */
    private $repo;

    private $em;

    public function __construct(UserRepository $repo,ObjectManager $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }
    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->render("Home/home.html.twig");
    }
}