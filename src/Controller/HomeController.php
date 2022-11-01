<?php

namespace App\Controller;

use App\Entity\Token;
use App\Service\ApiService;
use App\Entity\Portefeuille;
use App\Service\TokenCollection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;





class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
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
        $token  =  $managerRegistry->getRepository(Token::class)->findAll();
        $wallet = $managerRegistry->getRepository(Portefeuille::class)->findAll();
        foreach ($wallet as $key => $value) {
           $sum[] = ($value->getQuantity());
        }
        if (isset($sum)) {
            $sum = array_sum($sum);
        } else {
            $sum = 0;
        }
     
        
        return $this->render('home/index.html.twig', [
            'tokens' => $token,
            'wallet' => $sum,
           
        ]);



    }
}
