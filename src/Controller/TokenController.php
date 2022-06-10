<?php

namespace App\Controller;

use App\Entity\Token;
use App\Form\TokenType;
use App\Repository\TokenRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/token')]
class TokenController extends AbstractController
{
    #[Route('/', name: 'app_token_index', methods: ['GET'])]
    public function index(TokenRepository $tokenRepository): Response
    {
        $form = $this->createFormBuilder()
        ->add('name', EntityType::class, [
            'class' => Token::class,
            'choice_label' => 'name',
            'multiple' => false,
            'expanded' => false,
            'required' => true,
            'empty_data' => '',
            'placeholder' => 'Choisissez une ou plusieurs cryptomonnaies',
            ])
        ->add('prix',TextType::class,[
            'required' => false,
            
        ] )
        ->add('Quantité',TextType::class, )
        ->add('submit', SubmitType::class, [
            'label' => 'Valider',
            'attr' => [
                'class' => 'btn btn-primary',
            ],
        ])
            ->getForm();
    return $this->renderForm('home/add.html.twig',compact('form'));
    }

    #[Route('/new', name: 'app_token_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TokenRepository $tokenRepository): Response
    {
        $token = new Token();
        $form = $this->createForm(TokenType::class, $token);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tokenRepository->add($token, true);

            return $this->redirectToRoute('app_token_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('token/new.html.twig', [
            'token' => $token,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_token_show', methods: ['GET'])]
    public function show(Token $token): Response
    {
        return $this->render('token/show.html.twig', [
            'token' => $token,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_token_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Token $token, TokenRepository $tokenRepository): Response
    {
        $form = $this->createForm(TokenType::class, $token);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tokenRepository->add($token, true);

            return $this->redirectToRoute('app_token_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('token/edit.html.twig', [
            'token' => $token,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_token_delete', methods: ['POST'])]
    public function delete(Request $request, Token $token, TokenRepository $tokenRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$token->getId(), $request->request->get('_token'))) {
            $tokenRepository->remove($token, true);
        }

        return $this->redirectToRoute('app_token_index', [], Response::HTTP_SEE_OTHER);
    }
}
