<?php

namespace App\Controller\Stats;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{
    #[Route('/stats', name: 'app_stats')]
    public function index(): Response
    {

        $stats = [
            'visitors' => 1234,
            'date' => (new \DateTime())->format('Y-m-d'),
            'counter' => 42,
        ];

        return $this->render('stats/stats.html.twig', [
            'stats' => $stats,
        ]);
    }
}
