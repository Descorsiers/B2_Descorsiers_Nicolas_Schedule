<?php

namespace App\Controller;

use App\Entity\GlobalNews;
use App\Form\GlobalNewsType;
use App\Repository\GlobalNewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/global/news')]
final class GlobalNewsController extends AbstractController
{
    #[Route(name: 'app_global_news_index', methods: ['GET'])]
    public function index(GlobalNewsRepository $globalNewsRepository): Response
    {
        return $this->render('global_news/index.html.twig', [
            'global_news' => $globalNewsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_global_news_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $globalNews = new GlobalNews();
        $form = $this->createForm(GlobalNewsType::class, $globalNews);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($globalNews);
            $entityManager->flush();

            return $this->redirectToRoute('app_global_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('global_news/new.html.twig', [
            'global_news' => $globalNews,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_global_news_show', methods: ['GET'])]
    public function show(GlobalNews $globalNews): Response
    {
        return $this->render('global_news/show.html.twig', [
            'global_news' => $globalNews,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_global_news_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GlobalNews $globalNews, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GlobalNewsType::class, $globalNews);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_global_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('global_news/edit.html.twig', [
            'global_news' => $globalNews,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_global_news_delete', methods: ['POST'])]
    public function delete(Request $request, GlobalNews $globalNews, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$globalNews->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($globalNews);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_global_news_index', [], Response::HTTP_SEE_OTHER);
    }
}
