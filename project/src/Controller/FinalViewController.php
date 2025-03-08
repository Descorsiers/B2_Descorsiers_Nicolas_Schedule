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
        $today = $date->format('Y-m-d');
        $tomorrow = $date->modify('+1day');
        $test = $repository->findOneBy(['date' => $tomorrow]);
        // dd($day);
        return $this->render('final_view/index.html.twig', [
            'controller_name' => 'FinalViewController', 
            'todaySchedule' => $day,
            'tomorrow' => $test,
            'tomorrowSchedule' => $tomorrow->format('Y-m-d'),
            'date' => $date->format('Y-m-d'),
        ]);
    }
}
