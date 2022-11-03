<?php

namespace App\Controller;

use App\Repository\PortefeuilleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[Route('/chartjs')]
#[IsGranted('ROLE_USER')]

class ChartjsController extends AbstractController
{
    #[Route('/', name: 'app_chartjs_index',  methods: ['GET'])]
    public function index(
        PortefeuilleRepository $portefeuilleRepository,
        ChartBuilderInterface $chartBuilder
    ): Response
    {
        $portefeuille = $portefeuilleRepository->findAll();

        $labels = [];
        $data = [];
        foreach ($portefeuille as $portefeuilles) {
            $labels[] = $portefeuilles->getName();
            $data[] = $portefeuilles->getQuantity();
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Valeurs du portefeuille en €',
                    'backgroundColor' => ['red', 'green', 'blue', 'yellow', 'orange', 'purple', 'pink', 'grey', 'black', 'brown'],
                    'data' => $data,
                ],
            ],
        ]);

        return $this->render('chartjs/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
