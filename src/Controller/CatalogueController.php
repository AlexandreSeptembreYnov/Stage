<?php

namespace App\Controller;

use App\Entity\Ouvrage;
use App\Entity\User;
use App\Repository\AuteurRepository;
use App\Repository\ThemeRepository;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Repository\OuvrageRepository;
use App\Form\OuvrageType;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CatalogueController extends AbstractController
{
    /**
     * @var OuvrageRepository
     */
    private $repository;
    private $repo;
    private $em;
    public $user;
    private $repoTheme;
    private $repoAuteur;

    public function __construct(OuvrageRepository $repository, ObjectManager $em, UserRepository $repo, ThemeRepository $repoTheme, AuteurRepository $repoAuteur)
    {
        $this->repoAuteur = $repoAuteur;
        $this->repoTheme = $repoTheme;
        $this->repository = $repository;
        $this->em = $em;
        $this->repo = $repo;
        $_SESSION['email'] = "test@gmail.com";
        if ($_SESSION['email'] != null) {
            $test1 = $this->repo->findByMail($_SESSION['email']);
            if ($test1 == []) {
                $this->user = new User();
                $test = $this->repo->findByRole('ROLE_ADMIN');
                $this->user->setEmail($_SESSION['email']);
                if (in_array($this->user->getEmail(), $test)) {
                    $this->user->setRole("ROLE_ADMIN");
                } else {
                    $this->user->setRole("ROLE_USER");
                }
                $this->em->persist($this->user);
                $this->em->flush();
            } else {
                $this->user = $test1[0];
            }
        } else {
            return $this->redirectToRoute("home");
        }

    }

    /**
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $ouvrage = $paginator->paginate(
            $this->repository->findAllQuerry(),
            $request->query->getInt('page', 1),
            12
        );
        $theme = $this->repoTheme->findAll();
        $auteur = $this->repoAuteur->findAll();
        $newOuvrage = new Ouvrage();
        $form = $this->createForm(OuvrageType::class, $newOuvrage);
        $form->handleRequest($request);
        $str = "drama";
        $search = $this->createFormBuilder()
            ->add('search', TextType::class)
            ->getForm();
        if ($search->isSubmitted() && $search->isValid()){
            $ouvrage = $paginator->paginate(
                $this->repository->search($str),
                $request->query->getInt('page', 1),
                12
            );
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($newOuvrage);
            $this->em->flush();
            return $this->redirectToRoute("catalogue");
        }
        dump($ouvrage);
        return $this->render("catalogue/catalogue.html.twig",
            [
                'ouvrages' => $ouvrage,
                'user' => $this->user,
                'theme' => $theme,
                'auteur' => $auteur,
                'forms' => $form->createView(),
                'search' => $search->createView()
            ]);
    }


    public function del(Request $request): Response
    {
        if ($this->user->getRole() == "ROLE_ADMIN") {
            $id = $request->query->get('id');
            $ouvrage = $this->repository->find($id);
            $this->em->remove($ouvrage);
            $this->em->flush();
            return $this->render("Home/Home.html.twig");
        }
    }
    public function edit(Request $request): Response
    {
        if ($this->user->getRole() == "ROLE_ADMIN") {
            $id = $request->query->get('id');
            $numero = $request->query->get('num');
            $titre = $request->query->get('titre');
            $themeId = $request->query->get('themeId');
            $auteurId= $request->query->get('auteurId');
            $themeId = $this->repoTheme->find($themeId);
            $auteurId = $this->repoAuteur->find($auteurId);
            dump($themeId, $auteurId);
            $ouvrage = $this->repository->find($id);
            $ouvrage->setTitre($titre);
            $ouvrage->setNumero($numero);
            $ouvrage->setAuteurId($auteurId);
            $ouvrage->setThemeId($themeId);
            dump($ouvrage);
            $this->em->flush();
            return $this->render("Home/Home.html.twig");
        }
    }
}