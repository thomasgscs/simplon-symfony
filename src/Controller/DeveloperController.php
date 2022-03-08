<?php

namespace App\Controller;

use App\Entity\Developer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_USER')]
class DeveloperController extends AbstractController
{
    #[Route('/developer', name: 'app_developer_index')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $developer = new Developer();

        $form = $this->createFormBuilder($developer)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Developer'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $developer = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($developer);
            $entityManager->flush();

            return $this->redirectToRoute('app_developer_index');
        }

        return $this->renderForm('pages/developer/index.html.twig', [
            'form' => $form,
            'developersList' => $doctrine->getRepository(Developer::class)->findAll()
        ]);
    }
}
