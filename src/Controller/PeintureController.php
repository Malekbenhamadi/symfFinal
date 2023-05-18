<?php

namespace App\Controller;

use App\Entity\Peinture;
use App\Form\PeintureType;
use App\Repository\PeintureRepository;
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
    public function edit(Request $request, Peinture $peinture, PeintureRepository $peintureRepository): Response
    {
        $form = $this->createForm(PeintureType::class, $peinture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $peintureRepository->save($peinture, true);

            return $this->redirectToRoute('app_peinture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('peinture/edit.html.twig', [
            'peinture' => $peinture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_peinture_delete', methods: ['POST'])]
    public function delete(Request $request, Peinture $peinture, PeintureRepository $peintureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$peinture->getId(), $request->request->get('_token'))) {
            $peintureRepository->remove($peinture, true);
        }

        return $this->redirectToRoute('app_peinture_index', [], Response::HTTP_SEE_OTHER);
    }
}
