<?php

namespace App\Controller;

use App\Entity\Coaster;
use App\Form\CoasterType;
use App\Repository\CoasterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoasterController extends AbstractController
{
    #[Route('/coaster', name: 'coaster_index', methods: ['GET'])]
    public function index(CoasterRepository $coasterRepository): Response
    {
        return $this->render('coaster/index.html.twig', [
            'coasters' => $coasterRepository->findAll(),
        ]);
    }

    #[Route('/coaster/new', name: 'coaster_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $coaster = new Coaster();
        $form = $this->createForm(CoasterType::class, $coaster);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($coaster);
            $em->flush();

            return $this->redirectToRoute('coaster_index');
        }

        return $this->render('coaster/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/coaster/{id}/edit', name: 'coaster_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Coaster $coaster, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CoasterType::class, $coaster);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('coaster_index');
        }

        return $this->render('coaster/edit.html.twig', [
            'form' => $form,
            'coaster' => $coaster,
        ]);
    }

    #[Route('/coaster/{id}/delete', name: 'coaster_delete', methods: ['POST'])]
    public function delete(Request $request, Coaster $coaster, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coaster->getId(), $request->request->get('_token'))) {
            $em->remove($coaster);
            $em->flush();
        }

        return $this->redirectToRoute('coaster_index');
    }
}
