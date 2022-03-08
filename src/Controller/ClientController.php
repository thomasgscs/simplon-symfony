<?php

namespace App\Controller;

use App\Entity\Client;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client_index')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $client = new Client();

        $form = $this->createFormBuilder($client)
            ->add('name', TextType::class)
            ->add('websiteUrl', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Client'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_client_index');
        }

        return $this->renderForm('pages/client/index.html.twig', [
            'form' => $form,
            'clientsList' => $doctrine->getRepository(Client::class)->findAll()
        ]);
    }
}
