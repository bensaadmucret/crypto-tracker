<?php

namespace App\Controller;

use App\Entity\Token;
use App\Entity\Portefeuille;
use App\Service\TokenCollection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WalletController extends AbstractController
{
    #[Route('/wallet', name: 'app_wallet')]
    public function index(Request $request, ManagerRegistry $managerRegistry): Response
    {
    

        
        return $this->render('wallet/index.html.twig');
    
       
        
    }
}
