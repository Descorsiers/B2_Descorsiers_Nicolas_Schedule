<?php

namespace App\Controller;

use App\Entity\DaySchedule;
use App\Entity\GlobalNews;
use DateTime;
use DateTimeImmutable;
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
        $globalNews  = $em->getRepository(GlobalNews::class)->findOneBy([],['id' => 'DESC']);
        $date = new DateTimeImmutable();
        $dateTomorrow = $date->modify('+1day');
        $dayB1 = $repository->findBy(['date' => $date, 'grade' => 'B1']);
        $dayB2 = array('dev' => $repository->findBy(['date' => $date, 'grade' => 'B2Dev']),'design' => $repository->findBy(['date' => $date, 'grade' => 'B2Design']));
        $dayB3 = $repository->findBy(['date' => $date, 'grade' => 'B3']);
        $tomorrowB1 = $repository->findBy(['date' => $dateTomorrow, 'grade' => 'B1']);
        $tomorrowB2 = array('dev' => $repository->findBy(['date' => $dateTomorrow, 'grade' => 'B2Dev']),'design' => $repository->findBy(['date' => $dateTomorrow, 'grade' => 'B2Design']));
        $tomorrowB3 = $repository->findBy(['date' => $dateTomorrow, 'grade' => 'B3']);
        $week =null;
        $data = simplexml_load_file("https://www.amiens.fr/flux-rss/actus");
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
            $week = "Pas de cours !";
        }
        return $this->render('final_view/index.html.twig', [
            'B1' => $dayB1,
            'B2' => $dayB2,
            'B3' => $dayB3,
            'tomorrowB1' => $tomorrowB1,
            'tomorrowB2' => $tomorrowB2,
            'tomorrowB3' => $tomorrowB3,
            'week' => $week,
            'rss' => $data->channel,
            'globalNews' => $globalNews,
        ]);
    }
}
