<?php

namespace App\Controller;

use App\Entity\Portefeuille;
use App\Form\PortefeuilleType;
use App\Repository\PortefeuilleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/portefeuille')]
#[IsGranted('ROLE_USER')]
class PortefeuilleController extends AbstractController
{
    #[Route('/', name: 'app_portefeuille_index', methods: ['GET'])]
    public function index(PortefeuilleRepository $portefeuilleRepository): Response
    {
        return $this->render('portefeuille/index.html.twig', [
            'portefeuilles' => $portefeuilleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_portefeuille_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PortefeuilleRepository $portefeuilleRepository): Response
    {
        $portefeuille = new Portefeuille();
        $form = $this->createForm(PortefeuilleType::class, $portefeuille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $portefeuilleRepository->add($portefeuille, true);

            return $this->redirectToRoute('app_portefeuille_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('portefeuille/new.html.twig', [
            'portefeuille' => $portefeuille,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portefeuille_show', methods: ['GET'])]
    public function show(Portefeuille $portefeuille): Response
    {
        return $this->render('portefeuille/show.html.twig', [
            'portefeuille' => $portefeuille,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_portefeuille_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Portefeuille $portefeuille, PortefeuilleRepository $portefeuilleRepository): Response
    {
        $form = $this->createForm(PortefeuilleType::class, $portefeuille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $portefeuilleRepository->add($portefeuille, true);

            return $this->redirectToRoute('app_portefeuille_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('portefeuille/edit.html.twig', [
            'portefeuille' => $portefeuille,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portefeuille_delete', methods: ['POST'])]
    public function delete(Request $request, Portefeuille $portefeuille, PortefeuilleRepository $portefeuilleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$portefeuille->getId(), $request->request->get('_token'))) {
            $portefeuilleRepository->remove($portefeuille, true);
        }

        return $this->redirectToRoute('app_portefeuille_index', [], Response::HTTP_SEE_OTHER);
    }
}
