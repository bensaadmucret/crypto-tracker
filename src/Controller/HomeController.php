<?php

namespace App\Controller;

use Exception;
use App\Entity\Token;
use App\Form\TokenType;

use App\Service\ApiService;
use App\Service\TokenCollection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;




class HomeController extends AbstractController
{

    #[Route('/home', name: 'app_home')]
    public function index(ApiService $ApiService, 
    ManagerRegistry $managerRegistry, 
     ): Response
    {
        try {
            $data = $ApiService->getApiData();
        } catch (\Exception $e) {
            $data = $e->getMessage();
            
        }

        $TokenCollection = new TokenCollection($data);
        $TokenCollection->save($managerRegistry);
        $token = $managerRegistry->getRepository(Token::class)->findAll();
        
        return $this->render('home/index.html.twig', [
            'tokens' => $token,
           
        ]);



    }
}
