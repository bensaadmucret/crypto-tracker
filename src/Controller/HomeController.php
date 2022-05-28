<?php

namespace App\Controller;

use Exception;
use App\Service\ApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
 
     
    #[Route('/home', name: 'app_home')]
    public function index(ApiService $ApiService): Response
    {
       
        try {
            $data = $ApiService->getApiData();
        } catch (\Exception $e) {
            $data = $e->getMessage();
            
           
        }
       
       dd($data);
       return $this->render('home/index.html.twig', [
        'data' => $data,
    ]);

    }
}
