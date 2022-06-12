<?php

namespace App\Controller;

use App\Entity\Token;
use App\Form\TokenType;
use App\Entity\Portefeuille;
use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/token')]
class TokenController extends AbstractController
{
    #[Route('/', name: 'app_token_index', methods: ['GET', 'POST'])]
    public function index(TokenRepository $tokenRepository, Request $request): Response
    {

        $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('app_token_index'))
        ->setMethod('POST')
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
        ->add('price', NumberType::class,[
            'required' => true,
            'label' => "Prix d'achat",
            'attr' => [
                'placeholder' => 'Transaction en €',
            ],
       
        ])
         ->getForm();
         $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                
                return $this->render('token/payment.html.twig', 
                ['name' => $data['name']->getName(), 'quantity' => $data['quantity'], 'price' => $data['price']]);
            }
            else {
                $this->addFlash('error', 'Transaction échouée');
                
            }
            return $this->render('home/add.html.twig', [
                'form' => $form->createView(),
                'tokens' => $tokenRepository->findAll(),
            ]);
            
    }

    #[Route('/payment', name: 'app_token_payment', methods: ['POST', 'GET'])]
    public function payement(Request $request, EntityManagerInterface $em): Response
    {   if($request->isMethod('GET')){
        return $this->redirectToRoute('app_token_index');
        }
        $data = $request->request->all();
       
        $wallet = new Portefeuille;
        $wallet->setName($data['crypto']);
        $wallet->setQuantity($data['quantity']);
        $wallet->setPrice($data['price']);

        $em->getRepository(Portefeuille::class);
        $em->persist($wallet);
        $em->flush();
        $this->addFlash('success', 'Transaction effectuée avec succès');
        return $this->redirectToRoute('app_home');
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
