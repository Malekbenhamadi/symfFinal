<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Peinture;
use App\Form\PeintureType;
use App\Form\CommentaireType;

use App\Repository\CommentaireRepository;
use App\Repository\PeintureRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/peinture')]
class PeintureController extends AbstractController
{
    #[Route('/', name: 'app_peinture_index', methods: ['GET'])]
    public function index(PeintureRepository $peintureRepository): Response
    {
        return $this->render('peinture/index.html.twig', [
            'peintures' => $peintureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_peinture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PeintureRepository $peintureRepository): Response
    {
        $peinture = new Peinture();
        $form = $this->createForm(PeintureType::class, $peinture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $peintureRepository->save($peinture, true);

            return $this->redirectToRoute('app_peinture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('peinture/new.html.twig', [
            'peinture' => $peinture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_peinture_show', methods: ['GET'])]
    public function show(Peinture $peinture): Response
    {
        return $this->render('peinture/show.html.twig', [
            'peinture' => $peinture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_peinture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Peinture $peinture, PeintureRepository $peintureRepository, CommentaireRepository $commentaireRepository): Response
    {
        $newCommentaires = new Commentaire;
        $form = $this->createForm(CommentaireType::class, $newCommentaires);
        $form->handleRequest($request);
        $newCommentaires->setPeinture($peinture);
        $newCommentaires->setUser($this->getUser());
        if ($form->isSubmitted() && $form->isValid()) {
            $date = new DateTimeImmutable(date("Y/m/d"));
            $mutable = DateTime::createFromInterface($date);
            $newCommentaires->setDate($mutable);
            $commentaireRepository->save($newCommentaires, true);
            //   $peinture->addCommentaire($newCommentaires);
            $peintureRepository->save($peinture, true);

            return $this->redirectToRoute('app_peinture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('peinture/edit.html.twig', [
            'peinture' => $peinture,
            'form' => $form,
            'commentaires' => $peinture->getCommentaires(),
            'nbCom'=>sizeof($peinture->getCommentaires()),
            'newCommentaires' => $newCommentaires,
        ]);
    }

    #[Route('/{id}', name: 'app_peinture_delete', methods: ['POST'])]
    public function delete(Request $request, Peinture $peinture, PeintureRepository $peintureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $peinture->getId(), $request->request->get('_token'))) {
            $peintureRepository->remove($peinture, true);
        }

        return $this->redirectToRoute('app_peinture_index', [], Response::HTTP_SEE_OTHER);
    }



}