<?php


namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\User;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class GestionAuteursController extends AbstractController
{

    /**
     * @var AuteurRepository
     */
    private $repository;
    private $repo;
    private $em;
    public $user;

    public function __construct(AuteurRepository $repository,ObjectManager $em, UserRepository $repo)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->repo =$repo;
        $_SESSION['email'] = "test@gmail.com";
        if($_SESSION['email'] != null){
            $test1 = $this->repo->findByMail($_SESSION['email']);
            if ($test1 == [])
            {
                $this->user = new User();
                $test = $this->repo->findByRole('ROLE_ADMIN');
                $this->user->setEmail($_SESSION['email']);
                if(in_array($this->user->getEmail(),$test))
                {
                    $this->user->setRole("ROLE_ADMIN");
                }
                else{$this->user->setRole("ROLE_USER");}
                $this->em->persist($this->user);
                $this->em->flush();
            }
            else {
                $this->user = $test1[0];
            }
        }
        else{return $this->redirectToRoute("home");}

    }

    /**
     * @return Response
     */
    public function index(Request $request): Response
    {
        $auteur = $this->repository->findAll();
        $newAuteur = new Auteur();
        $form = $this->createForm(AuteurType::class, $newAuteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($newAuteur);
            $this->em->flush();
            return $this->redirectToRoute("Gestion.Auteurs.index");
        }
        return $this->render("Gestion/GestionAuteur/GestionAuteurs.html.twig",
            [
                'auteurs' => $auteur,
                'forms' => $form->createView(),
                'user' => $this->user
            ]);
    }


    public function del(Request $request): Response
    {
        if ($this->user->getRole() == "ROLE_ADMIN"){
            $id = $request->query->get('id');
            $auteur = $this->repository->find($id);
            $this->em->remove($auteur);
            $this->em->flush();
            return $this->render("Home/Home.html.twig");
        }
    }

    public function edit(Request $request): Response
    {
        if ($this->user->getRole() == "ROLE_ADMIN"){
            $id = $request->query->get('id');
            $libelle = $request->query->get('libelle');
            $auteur = $this->repository->find($id);
            $auteur->setLibelle($libelle);
            $this->em->flush();
            return $this->render("Home/Home.html.twig");
        }
    }
}