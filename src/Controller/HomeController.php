<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Commentaire;
use App\Entity\Categorie;
use App\Entity\Peinture;


use App\Repository\PeintureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(PeintureRepository $peintureRepository): Response
    {
        $aux=$this->getUser();
        if($this->getUser()==null)
        {
       return $this->redirectToRoute('login');

        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'user'=>$aux,
            'peintures' => $peintureRepository->findAll(),
        ]);
    }
}
