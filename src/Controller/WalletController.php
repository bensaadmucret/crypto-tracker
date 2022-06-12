<?php

namespace App\Controller;

use App\Entity\Portefeuille;
use Symfony\UX\Chartjs\Model\Chart;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WalletController extends AbstractController
{
    #[Route('/wallet', name: 'app_wallet')]
    #[IsGranted('ROLE_USER')]
    public function index(ChartBuilderInterface $builderchart, ManagerRegistry $managerRegistry): Response
    { 
        $label = [];
        $quantity = [];
        $price = [];
        $wallet = $managerRegistry->getRepository(Portefeuille::class)->findAll();
        foreach ($wallet as $key => $value) {
            $label[] = ($value->getName());
            $quantity[] = ($value->getQuantity());
            $price[] = ($value->getPrice());
        }
        $date = (new \DateTime())->format('d-m-Y');
        $sum = array_sum($quantity);

        

        $chart = $builderchart->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => array_reverse($label),
            'datasets' => [
                [
                    'label' => 'Quantité',
                    'data' => $quantity,
                    'borderColor' => 'rgb(31,195,108)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Prix',
                    'data' => $price,
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
                
            ],
        ]);
        $chart->setOptions([]);

        return $this->render('wallet/index.html.twig', [
            'chart' => $chart,
            'sum' => $sum,
            'wallet' => $wallet,
            'date' => $date

        ]);
        
    
    }
    
}
