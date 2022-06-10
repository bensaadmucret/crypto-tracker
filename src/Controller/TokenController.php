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
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/token')]
class TokenController extends AbstractController
{
    #[Route('/', name: 'app_token_index', methods: ['GET'])]
    public function index(TokenRepository $tokenRepository, Request $request): Response
    {

        $form = $this->createFormBuilder( )
        ->setAction($this->generateUrl('app_token_new'))
        ->add('name', EntityType::class, [
            'class' => Token::class,
            'choice_label' => 'name',
            'choice_value' => 'price',
            'label' => 'Cryptomonnaies',
            'multiple' => false,
            'expanded' => false,
            'required' => true,
            'empty_data' => '',
            'placeholder' => 'Choisissez une cryptomonnaies',
            ])

        ->add('quantity',MoneyType::class,[
                'required' => true,
                'label' => "Quantité",
                'attr' => [
                    'placeholder' => 'Entrez la quantité',
                    'class' => 'form-control'
                ]
            ])
               
        ->add('price',MoneyType::class,[
            'required' => true,
            'label' => "Prixd'achat",
            'attr' => [
                'placeholder' => 'Transaction en €',
            ],
       
        ])
         ->getForm();
            $form->submit($request->request->all());
            $form->handleRequest($request);
            $data = $form->getData();
            $name = $data['name'];
            $price = $data['price'];
            $quantity = $data['quantity'];
            
            if ($form->isSubmitted() && $form->isValid()) {
                $this->addFlash('success', 'Transaction effectuée avec succès');
                return $this->redirectToRoute('app_token_new');
            }
            else {
                $this->addFlash('error', 'Transaction échouée');
                
            }
          

            return $this->render('home/add.html.twig', [
                'form' => $form->createView(),
                'tokens' => $tokenRepository->findAll(),
            ]);
            
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
