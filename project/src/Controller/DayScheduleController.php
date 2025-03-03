<?php

namespace App\Controller;

use App\Entity\DaySchedule;
use App\Form\DayScheduleType;
use App\Repository\DayScheduleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day/schedule')]
final class DayScheduleController extends AbstractController
{
    #[Route(name: 'app_day_schedule_index', methods: ['GET'])]
    public function index(DayScheduleRepository $dayScheduleRepository): Response
    {
        return $this->render('day_schedule/index.html.twig', [
            'day_schedules' => $dayScheduleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_day_schedule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $daySchedule = new DaySchedule();
        $form = $this->createForm(DayScheduleType::class, $daySchedule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($daySchedule);
            $entityManager->flush();

            return $this->redirectToRoute('app_day_schedule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('day_schedule/new.html.twig', [
            'day_schedule' => $daySchedule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_day_schedule_show', methods: ['GET'])]
    public function show(DaySchedule $daySchedule): Response
    {
        return $this->render('day_schedule/show.html.twig', [
            'day_schedule' => $daySchedule,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_day_schedule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DaySchedule $daySchedule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DayScheduleType::class, $daySchedule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_day_schedule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('day_schedule/edit.html.twig', [
            'day_schedule' => $daySchedule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_day_schedule_delete', methods: ['POST'])]
    public function delete(Request $request, DaySchedule $daySchedule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$daySchedule->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($daySchedule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_day_schedule_index', [], Response::HTTP_SEE_OTHER);
    }
}
