<?php

namespace App\Controller;

use App\Entity\DaySchedule;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FinalViewController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $em): Response   
    {
        $repository = $em->getRepository(DaySchedule::class);
        $date = new DateTime();
        $day = $repository->findBy(['date' => $date]);
        $dayB1 = $repository->findBy(['date' => $date, 'grade' => 'B1']);
        $dayB2 = $repository->findBy(['date' => $date, 'grade' => 'B2Dev' or 'B2Design']);
        $dayB3 = $repository->findBy(['date' => $date, 'grade' => 'B3']);
        $today = $date->format('Y-m-d');
        $tomorrow = $date->modify('+1day');
        $test = $repository->findOneBy(['date' => $tomorrow]);
        $week =null;
        if ($dayB1[0]) {
            $todayName = $dayB1[0]->getName()->name;
            $week = [
                'first' => null,
                'last' => null,
            ];
            if ($todayName == 'Lundi') {
                $week['first'] = $date->format('d-M-y');
                $week['last'] = $date->modify('+4day')->format('d-M-y');
            }
            elseif ($todayName == 'Mardi') {
                $week['first'] = $date->modify('-1day')->format('d-M-y');
                $week['last'] = $date->modify('+3day')->format('d-M-y');
            }
            elseif ($todayName == 'Mercredi') {
                $week['first'] = $date->modify('-2day')->format('d-M-y');
                $week['last'] = $date->modify('+2day')->format('d-M-y');
            }
            elseif ($todayName == 'Jeudi') {
                $week['first'] = $date->modify('-3day')->format('d-M-y');
                $week['last'] = $date->modify('+1day')->format('d-M-y');
            }
            elseif ($todayName == 'Vendredi') {
                $week['first'] = $date->modify('-4day')->format('d-M-y');
                $week['last'] = $date->format('d-M-y');
            }
        }
        else{
            $week = "Pas de cours le week-end !";
        }
        // dd($dayB1);
        return $this->render('final_view/index.html.twig', [
            'B1' => $dayB1,
            'B2' => $dayB2,
            'B3' => $dayB3,
            'week' => $week,
            'tomorrowSchedule' => $tomorrow->format('Y-m-d'),
            'date' => $date->format('Y-m-d'),
        ]);
    }
}
